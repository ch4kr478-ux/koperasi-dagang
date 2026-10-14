<script>
    $(function () {
        var $product = $('select[name="produk_pinjaman_id"]');
        var $tenor = $('select[name="lama_cicilan"]');
        var $amount = $('#nominal_pinjaman_kredit');
        var selectedTenor = String($tenor.data('selected') || '');
        var initialProduct = String($product.val() || '');
        var initialAmount = parseInt(String($amount.val() || '').replace(/\D/g, ''), 10) || 0;

        var formatRupiah = function (amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(amount);
        };

        var updateSummary = function () {
            var amount = parseInt(String($amount.val() || '').replace(/\D/g, ''), 10) || 0;
            var months = parseInt($tenor.val(), 10) || 0;

            if (amount <= 0 || months <= 0) {
                $('#preview-pokok, #preview-bunga, #preview-tabungan, #preview-total').text('-');
                return;
            }

            var principal = Math.floor(amount / months);
            var interest = Math.round(amount * 0.01);
            var savings = Math.round(amount * 0.005);

            $('#preview-pokok').text(formatRupiah(principal));
            $('#preview-bunga').text(formatRupiah(interest));
            $('#preview-tabungan').text(formatRupiah(savings));
            $('#preview-total').text(formatRupiah(principal + interest + savings));
        };

        var updateAmount = function () {
            var amount = String($product.val() || '') === initialProduct && initialAmount > 0
                ? initialAmount
                : Number($product.find('option:selected').data('nominal')) || 0;
            if (amount > 0) {
                $amount.val('Rp. ' + new Intl.NumberFormat('id-ID', {
                    maximumFractionDigits: 0
                }).format(amount));
            } else if (String($product.val() || '') !== initialProduct) {
                $amount.val('');
            }
        };

        var updateTenors = function () {
            var $option = $product.find('option:selected');
            var values = String($option.data('tenors') || '').split(',');
            var currentTenor = String($tenor.val() || selectedTenor);
            $tenor.empty().append($('<option>').val('').text('Pilih tenor'));

            $.each(values, function (_, value) {
                value = $.trim(value);
                if (!value) {
                    return;
                }

                $tenor.append($('<option>').val(value).text(value + ' bulan'));
            });

            if ($tenor.find('option[value="' + currentTenor + '"]').length) {
                $tenor.val(currentTenor);
            } else if ($tenor.find('option').length > 1) {
                $tenor.prop('selectedIndex', 1);
            }

            selectedTenor = '';
            updateAmount();
            updateSummary();
        };

        $product.on('change', updateTenors);
        $tenor.on('change', updateSummary);
        $amount.on('keyup change', updateSummary);
        updateTenors();
    });
</script>
