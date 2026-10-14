@permission($can_edit)
@php($formModel = $model)
<form method="post" action="{{ $form_url }}" class="form-inline js-confirm" data-confirm="{{ $confirm_message }}">
@csrf
@method('DELETE')

<a href="{{ $edit_url }}" class="btn btn-space btn-primary active btn-sm"><i class="mdi mdi-pencil" aria-hidden="true"></i> Ubah</a> |
@endpermission
@permission($can_delete)
<button type="submit" class="btn btn-space btn-danger active btn-sm"><i class="mdi mdi-delete" aria-hidden="true"></i> Hapus</button>
@endpermission
</form>
