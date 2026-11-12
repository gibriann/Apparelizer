<script>
    $(function () {
        var searchTimer;

        $(document).on('input', '.address-destination-search', function () {
            var input = $(this);
            var form = input.closest('.address-form');
            var results = form.find('.address-destination-results');
            var query = input.val().trim();

            clearTimeout(searchTimer);

            if (query.length < 3) {
                results.hide();
                return;
            }

            searchTimer = setTimeout(function () {
                $.ajax({
                    url: '/shipping/search-destination',
                    method: 'GET',
                    data: { search: query, limit: 10 },
                    success: function (response) {
                        if (response.meta && response.meta.status === 'success' && response.data.length > 0) {
                            var html = '';

                            response.data.forEach(function (item) {
                                var subdistrict = item.subdistrict_name || '';
                                var district = item.district_name || '';
                                var city = item.city_name || '';
                                var province = item.province_name || '';
                                var zipCode = item.zip_code || '';
                                var label = item.label || [subdistrict, district, city, province].filter(Boolean).join(', ');

                                html += '<a href="#" class="list-group-item list-group-item-action address-destination-item"'
                                    + ' data-id="' + item.id + '"'
                                    + ' data-label="' + label + '"'
                                    + ' data-province="' + province + '"'
                                    + ' data-city="' + city + '"'
                                    + ' data-district="' + district + '"'
                                    + ' data-subdistrict="' + subdistrict + '"'
                                    + ' data-zipcode="' + zipCode + '">'
                                    + '<div><strong>' + subdistrict + '</strong>' + (district ? ', ' + district : '') + '</div>'
                                    + '<div>' + city + (province ? ', ' + province : '') + '</div>'
                                    + '<small class="text-muted">Kode Pos: ' + (zipCode || '-') + '</small>'
                                    + '</a>';
                            });

                            results.html(html).show();
                        } else {
                            results.html('<div class="list-group-item">Tidak ada hasil ditemukan</div>').show();
                        }
                    },
                    error: function () {
                        results.html('<div class="list-group-item text-danger">Error mencari lokasi</div>').show();
                    }
                });
            }, 500);
        });

        $(document).on('click', '.address-destination-item', function (e) {
            e.preventDefault();

            var item = $(this);
            var form = item.closest('.address-form');

            form.find('.address-destination-search').val(item.data('label'));
            form.find('.address-destination-id').val(item.data('id'));
            form.find('.address-province').val(item.data('province'));
            form.find('.address-city').val(item.data('city'));
            form.find('.address-district').val(item.data('district'));
            form.find('.address-subdistrict').val(item.data('subdistrict'));
            form.find('.address-postal-code').val(item.data('zipcode'));

            item.closest('.address-destination-results').hide();
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('.address-destination-search, .address-destination-results').length) {
                $('.address-destination-results').hide();
            }
        });
    });

    function addressFormErrors(xhr) {
        var response = xhr.responseJSON || {};
        var errors = response.errors || {};
        var messages = [];

        Object.keys(errors).forEach(function (key) {
            errors[key].forEach(function (message) {
                messages.push(message);
            });
        });

        if (!messages.length) {
            messages.push(response.message || 'Terjadi kesalahan. Silakan coba lagi.');
        }

        return messages;
    }
</script>
