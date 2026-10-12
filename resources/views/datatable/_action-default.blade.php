@permission($can_edit)
@php($formModel = $model)
<form method="post" action="{{ $form_url }}" class="form-inline js-confirm" data-confirm="{{ $confirm_message }}">
@csrf
@method('DELETE')

<a href="{{ $edit_url }}" class="btn btn-space btn-primary active btn-sm">Ubah</a> |
@endpermission
@permission($can_delete)
<input type="submit" value="Hapus" class="btn btn-space btn-danger active btn-sm">
@endpermission
</form>
