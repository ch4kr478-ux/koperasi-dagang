<script>
    $(function () {
        var $member = $('select[name="anggota_id"]');
        var $loan = $('#transaksi_pinjaman_id');
        var $principal = $('input[name="nominal_pinjaman"]');
        var $interest = $('input[name="nominal_bunga"]');

        if (!$loan.length) {
            return;
        }

        var formatRupiah = function (amount) {
            return 'Rp. ' + new Intl.NumberFormat('id-ID', {
                maximumFractionDigits: 0
            }).format(amount);
        };

        var filterLoans = function () {
            var memberId = String($member.val() || '');
            var selected = $loan.find('option:selected');

            if (selected.val() && String(selected.data('anggota')) !== memberId) {
                $loan.val('');
            }

            $loan.find('option').each(function () {
                var $option = $(this);
                var optionMember = String($option.data('anggota') || '');
                $option.prop('hidden', Boolean(optionMember && optionMember !== memberId));
            });

            updateInstallment();
        };

        var updateInstallment = function () {
            var $option = $loan.find('option:selected');
            var linked = Boolean($option.val());

            $principal.prop('readonly', linked);
            $interest.prop('readonly', linked);
            if (linked) {
                var principal = Number($option.data('pokok')) || 0;
                var interest = Number($option.data('bunga')) || 0;
                var savings = Number($option.data('tabungan')) || 0;
                var total = Number($option.data('total')) || 0;

                $principal.val(formatRupiah(principal));
                $interest.val(formatRupiah(interest));
                $('#angsuran_ke').val($option.data('angsuran'));
                $('#cicilan-kredit-summary').text(
                    'Angsuran ke-' + $option.data('angsuran') +
                    ' (jatuh tempo ' + $option.data('jatuh-tempo') + '): Pokok ' +
                    formatRupiah(principal) + ', bunga ' + formatRupiah(interest) +
                    ', simpanan wajib ' + formatRupiah(savings) +
                    '. Total dibayar: ' + formatRupiah(total) + '.'
                ).show();
            } else {
                $('#angsuran_ke').val('');
                $('#cicilan-kredit-summary').hide().text('');
            }
        };

        $member.on('change', filterLoans);
        $loan.on('change', updateInstallment);
        filterLoans();
    });
</script>
