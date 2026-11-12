{{--
    Round avatar picker with pan & zoom.
    Expects: $user (defaults to logged in user), $inputId
--}}
@php
    $user = $user ?? Auth::user();
    $inputId = $inputId ?? 'avatar-upload';
    $hasAvatar = $user->hasCustomAvatar();
@endphp

<div class="avatar-picker {{ $hasAvatar ? 'avatar-picker--has-avatar' : '' }}" data-avatar-picker>
    <div class="avatar-preview-frame">
        <img class="avatar-preview" src="{{ $user->avatar_url }}" alt="Foto Profil" data-avatar-preview>
    </div>

    <input type="file"
           accept="image/png,image/jpeg,image/webp"
           name="avatar"
           id="{{ $inputId }}"
           class="d-none @error('avatar') is-invalid @enderror"
           data-avatar-input />

    <label for="{{ $inputId }}" class="avatar-dropzone">
        <i class="fas fa-camera" aria-hidden="true"></i>
        {{ $hasAvatar ? 'Ganti Foto' : 'Unggah Foto' }}
    </label>

    @error('avatar')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror

    {{--
        The crop modal lives inside this wrapper for markup cohesion only.
        On boot the script appends it to <body>, because AOS puts a CSS
        transform on the surrounding card and a transformed ancestor makes
        position: fixed resolve against that card instead of the viewport —
        which clips the modal to a sliver of the page.
    --}}
    <div data-avatar-modal-host>
        <div class="modal fade" id="avatarCropModal" tabindex="-1" role="dialog" aria-labelledby="avatarCropTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="avatarCropTitle">Atur Posisi Foto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="small text-muted mb-3">
                            Geser foto untuk mengatur posisi, gunakan slider untuk memperbesar atau memperkecil.
                        </p>

                        <div class="avatar-cropper" data-avatar-cropper>
                            <img class="avatar-cropper-image" alt="Pratinjau foto" data-avatar-cropper-image>
                        </div>

                        <div class="form-group mt-4 mb-0">
                            <label for="avatarZoom" class="small font-weight-bold">Perbesaran</label>
                            <input type="range" class="custom-range" id="avatarZoom" min="1" max="3" step="0.01" value="1" data-avatar-zoom />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-success text-white" data-avatar-apply>Gunakan Foto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
