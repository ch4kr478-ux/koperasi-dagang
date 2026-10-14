@if ($model->is_close == 0)
<div class="datatable-actions">
    @permission($can_edit)
        <a href="{{ $edit_url }}" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil" aria-hidden="true"></i> Ubah</a>
    @endpermission
    @permission($can_delete)
        <form method="post" action="{{ $form_url }}" class="js-confirm" data-confirm="{{ $confirm_message }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="mdi mdi-delete" aria-hidden="true"></i> Hapus</button>
        </form>
    @endpermission
</div>
@endif
