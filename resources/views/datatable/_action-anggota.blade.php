<form method="post" action="{{ $form_url }}" class="form-inline">
    @csrf
    @method('DELETE')

    @permission($can_edit)
    <a href="{{ $edit_url }}" class="btn btn-space btn-primary active btn-sm">Ubah</a>
    @endpermission
    @permission($can_delete)
    <button type="submit" class="btn btn-space btn-danger active btn-sm"
        onclick="return confirm('{{ addslashes($confirm_message) }}')">Hapus</button>
    @endpermission
</form>
