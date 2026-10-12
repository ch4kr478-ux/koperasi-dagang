@php($formModel = $model)
<form method="post" action="{{ $form_url }}" class="form-inline js-confirm">
@csrf

<input type="submit" value="Tutup Buku" class="btn btn-space btn-success active btn-sm">
</form>