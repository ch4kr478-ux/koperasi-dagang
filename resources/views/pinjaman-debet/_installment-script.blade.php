<script>
    $(function () {
        var $member = $('select[name="anggota_id"]');
        var $loan = $('#transaksi_pinjaman_id');
        var $savings = $('#simpanan-angsuran');
        var $savingInputs = $savings.find('.simpanan-angsuran-input');

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

            if (linked) {
                var principal = Number($option.data('pokok')) || 0;
                var interest = Number($option.data('bunga')) || 0;
                $savings.show();
                $savingInputs.prop('disabled', false).prop('required', true);
                $('#angsuran_ke').val($option.data('angsuran'));
                $('#cicilan-kredit-summary').text(
                    'Angsuran ke-' + $option.data('angsuran') + ' dari ' + $option.data('total-angsuran') +
                    ' (jatuh tempo ' + $option.data('jatuh-tempo') + '): Pokok ' +
                    formatRupiah(principal) + ', bunga ' + formatRupiah(interest) +
                    '. Masukkan pokok dan bunga sesuai nilai tersebut; nominal simpanan diisi manual.'
                ).show();
            } else {
                $savings.hide();
                $savingInputs.prop('disabled', true).prop('required', false);
                $('#angsuran_ke').val('');
                $('#cicilan-kredit-summary').hide().text('');
            }
        };

        $member.on('change', filterLoans);
        $loan.on('change', updateInstallment);
        filterLoans();
    });
</script>
