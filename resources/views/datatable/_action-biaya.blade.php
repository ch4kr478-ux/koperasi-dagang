<div class="datatable-actions">
    @permission('manage-biaya')
        <a href="{{ $edit_url }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-pencil-outline" aria-hidden="true"></i> Edit
        </a>
        <form method="post" action="{{ $form_url }}" onsubmit="return confirm('{{ $confirm_message }}')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline" aria-hidden="true"></i> Hapus
            </button>
        </form>
    @endpermission
</div>
