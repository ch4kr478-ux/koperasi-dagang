@php($formModel = $model)
<form method="post" action="{{ $form_url }}" class="form-inline js-confirm">
@csrf

<button type="submit" class="btn btn-space btn-success active btn-sm"><i class="mdi mdi-book" aria-hidden="true"></i> Tutup Buku</button>
</form>