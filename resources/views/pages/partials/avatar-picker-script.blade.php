<script>
// avatar picker - the cropped circle replaces the file input, no libs needed
(function () {
    'use strict';

    var OUTPUT_SIZE = 512;
    var MAX_ZOOM = 3;

    var pickerEls = document.querySelectorAll('[data-avatar-picker]');
    if (!pickerEls.length) {
        return;
    }

    function boot(picker) {
        var input = picker.querySelector('[data-avatar-input]');
        var preview = picker.querySelector('[data-avatar-preview]');
        var label = picker.querySelector('.avatar-dropzone');
        var modalHost = picker.querySelector('[data-avatar-modal-host]');

        if (!input || !modalHost) {
            return;
        }

        // aos keeps a transform on the card, which clips position:fixed modals
        if (modalHost.parentNode !== document.body) {
            document.body.appendChild(modalHost);
        }

        var modalEl = modalHost.querySelector('#avatarCropModal');

        if (!modalEl) {
            return;
        }

        var cropper = modalEl.querySelector('[data-avatar-cropper]');
        var cropperImage = modalEl.querySelector('[data-avatar-cropper-image]');
        var zoomInput = modalEl.querySelector('[data-avatar-zoom]');
        var applyBtn = modalEl.querySelector('[data-avatar-apply]');

        var sourceFile = null;
        var sourceImage = null;
        var natural = { width: 0, height: 0 };

        var state = { size: 0, scale: 0, zoom: 1, offsetX: 0, offsetY: 0 };
        var dragging = false;
        var dragStart = null;

        function measure() {
            // clientWidth is 0 while hidden
            state.size = cropper.clientWidth || 360;
        }

        // smallest scale that still fills the circle
        function coverScale() {
            if (!natural.width || !natural.height) {
                return 1;
            }

            return Math.max(state.size / natural.width, state.size / natural.height);
        }

        function layout() {
            cropperImage.style.width = (natural.width * state.scale) + 'px';
            cropperImage.style.height = (natural.height * state.scale) + 'px';
            cropperImage.style.left = '50%';
            cropperImage.style.top = '50%';
            cropperImage.style.transform =
                'translate(-50%, -50%) translate(' + state.offsetX + 'px, ' + state.offsetY + 'px) scale(' + state.zoom + ')';
        }

        // won't let the photo slide past its own edges
        function clamp() {
            var renderedWidth = natural.width * state.scale * state.zoom;
            var renderedHeight = natural.height * state.scale * state.zoom;
            var maxX = Math.max(0, (renderedWidth - state.size) / 2);
            var maxY = Math.max(0, (renderedHeight - state.size) / 2);

            state.offsetX = Math.min(maxX, Math.max(-maxX, state.offsetX));
            state.offsetY = Math.min(maxY, Math.max(-maxY, state.offsetY));
        }

        function reset() {
            measure();
            state.scale = coverScale();
            state.zoom = 1;
            state.offsetX = 0;
            state.offsetY = 0;

            if (zoomInput) {
                zoomInput.disabled = false;
                zoomInput.value = 1;
            }

            layout();
        }

        function renderOutput(callback) {
            var canvas = document.createElement('canvas');
            canvas.width = OUTPUT_SIZE;
            canvas.height = OUTPUT_SIZE;

            var ctx = canvas.getContext('2d');
            // jpeg has no alpha
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, OUTPUT_SIZE, OUTPUT_SIZE);

            var ratio = OUTPUT_SIZE / state.size;
            var drawWidth = natural.width * state.scale * state.zoom * ratio;
            var drawHeight = natural.height * state.scale * state.zoom * ratio;
            var drawX = (OUTPUT_SIZE - drawWidth) / 2 + state.offsetX * ratio;
            var drawY = (OUTPUT_SIZE - drawHeight) / 2 + state.offsetY * ratio;

            ctx.imageSmoothingEnabled = true;
            ctx.imageSmoothingQuality = 'high';
            ctx.drawImage(sourceImage, drawX, drawY, drawWidth, drawHeight);

            canvas.toBlob(function (blob) {
                if (!blob) {
                    callback(null);
                    return;
                }

                var fileName = 'avatar-' + Date.now() + '.jpg';
                var cropped = new File([blob], fileName, { type: 'image/jpeg' });

                // if this fails the original file stays, server still crops
                try {
                    var transfer = new DataTransfer();
                    transfer.items.add(cropped);
                    input.files = transfer.files;
                } catch (error) {
                    console.warn('Avatar crop could not be applied:', error);
                }

                var previewUrl = URL.createObjectURL(blob);
                var previousUrl = preview.getAttribute('data-object-url');

                if (previousUrl) {
                    URL.revokeObjectURL(previousUrl);
                }

                preview.src = previewUrl;
                preview.setAttribute('data-object-url', previewUrl);
                picker.classList.add('avatar-picker--has-avatar');

                if (label) {
                    label.textContent = 'Ganti Foto';
                }

                callback(blob);
            }, 'image/jpeg', 0.9);
        }

        function openCropper(file) {
            if (!file || !/^image\//.test(file.type)) {
                return;
            }

            sourceFile = file;

            var objectUrl = URL.createObjectURL(file);
            var loader = new Image();

            loader.onload = function () {
                sourceImage = loader;
                natural = { width: loader.naturalWidth, height: loader.naturalHeight };

                // revoke after the img loads, not before
                cropperImage.onload = function () {
                    cropperImage.onload = null;
                    URL.revokeObjectURL(objectUrl);
                };
                cropperImage.src = objectUrl;

                // wait for the modal to have a width before measuring
                if (window.jQuery) {
                    window.jQuery(modalEl).modal('show');
                }

                var attempts = 0;

                function measureWhenVisible() {
                    if (cropper.clientWidth > 0 || attempts++ > 20) {
                        reset();
                        return;
                    }

                    window.requestAnimationFrame(measureWhenVisible);
                }

                measureWhenVisible();
            };

            loader.onerror = function () {
                URL.revokeObjectURL(objectUrl);
            };

            loader.src = objectUrl;
        }

        input.addEventListener('change', function () {
            var file = input.files && input.files[0];

            if (!file) {
                return;
            }

            openCropper(file);
        });

        ['dragenter', 'dragover'].forEach(function (eventName) {
            picker.addEventListener(eventName, function (event) {
                event.preventDefault();
                picker.classList.add('is-dragover');
            });
        });

        picker.addEventListener('dragleave', function () {
            picker.classList.remove('is-dragover');
        });

        picker.addEventListener('drop', function (event) {
            event.preventDefault();
            picker.classList.remove('is-dragover');

            var files = event.dataTransfer && event.dataTransfer.files;

            if (files && files[0]) {
                openCropper(files[0]);
            }
        });

        cropper.addEventListener('pointerdown', function (event) {
            if (event.button !== undefined && event.button !== 0) {
                return;
            }

            dragging = true;
            dragStart = {
                x: event.clientX,
                y: event.clientY,
                offsetX: state.offsetX,
                offsetY: state.offsetY,
            };

            cropper.classList.add('is-dragging');
            cropper.focus();

            // keeps the drag alive outside the circle
            if (cropper.setPointerCapture && event.pointerId !== undefined) {
                try {
                    cropper.setPointerCapture(event.pointerId);
                } catch (error) {
                }
            }
        });

        cropper.addEventListener('pointermove', function (event) {
            if (!dragging) {
                return;
            }

            state.offsetX = dragStart.offsetX + (event.clientX - dragStart.x);
            state.offsetY = dragStart.offsetY + (event.clientY - dragStart.y);

            clamp();
            layout();
        });

        function endDrag(event) {
            if (!dragging) {
                return;
            }

            dragging = false;
            cropper.classList.remove('is-dragging');
            cropper.releasePointerCapture && cropper.releasePointerCapture(event.pointerId);
        }

        cropper.addEventListener('pointerup', endDrag);
        cropper.addEventListener('pointercancel', endDrag);

        cropper.setAttribute('tabindex', '0');
        cropper.setAttribute('role', 'application');
        cropper.setAttribute('aria-label', 'Geser foto dengan tombol panah');

        cropper.addEventListener('keydown', function (event) {
            var step = event.shiftKey ? 20 : 5;
            var handled = true;

            switch (event.key) {
                case 'ArrowLeft': state.offsetX -= step; break;
                case 'ArrowRight': state.offsetX += step; break;
                case 'ArrowUp': state.offsetY -= step; break;
                case 'ArrowDown': state.offsetY += step; break;
                default: handled = false;
            }

            if (handled) {
                event.preventDefault();
                clamp();
                layout();
            }
        });

        cropper.addEventListener('wheel', function (event) {
            event.preventDefault();

            var next = state.zoom + (event.deltaY < 0 ? 0.08 : -0.08);
            state.zoom = Math.min(MAX_ZOOM, Math.max(1, next));
            state.scale = coverScale();

            if (zoomInput) {
                zoomInput.value = state.zoom;
            }

            clamp();
            layout();
        }, { passive: false });

        if (zoomInput) {
            zoomInput.addEventListener('input', function () {
                state.zoom = parseFloat(zoomInput.value) || 1;
                state.scale = coverScale();
                clamp();
                layout();
            });
        }

        if (applyBtn) {
            applyBtn.addEventListener('click', function () {
                if (!sourceImage) {
                    return;
                }

                applyBtn.disabled = true;
                applyBtn.textContent = 'Memproses...';

                renderOutput(function (blob) {
                    applyBtn.disabled = false;
                    applyBtn.textContent = 'Gunakan Foto';

                    if (blob && window.jQuery) {
                        window.jQuery(modalEl).modal('hide');
                    }
                });
            });
        }

        if (window.jQuery) {
            window.jQuery(modalEl).on('hidden.bs.modal', function () {
                applyBtn && (applyBtn.disabled = false);
                if (applyBtn) {
                    applyBtn.textContent = 'Gunakan Foto';
                }
            });
        }

        window.addEventListener('resize', function () {
            if (sourceImage) {
                reset();
            }
        });
    }

    for (var i = 0; i < pickerEls.length; i++) {
        boot(pickerEls[i]);
    }
})();
</script>
