<script>
    // fades the bottom of the list while there's more to scroll
    function refreshAddressPanel(scope) {
        var list = (scope || document).querySelector('.address-list');
        var wrap = list && list.closest('.address-panel__scroll');

        if (!wrap) {
            return;
        }

        var hasOverflow = list.scrollHeight > list.clientHeight + 4;
        var atBottom = list.scrollTop + list.clientHeight >= list.scrollHeight - 4;

        wrap.classList.toggle('has-overflow', hasOverflow && !atBottom);
    }

    $(function () {
        refreshAddressPanel();

        $(document).on('scroll', '.address-list', function () {
            refreshAddressPanel($(this).closest('[data-address-panel]')[0]);
        });

        $(window).on('resize', function () {
            refreshAddressPanel();
        });
    });
</script>
