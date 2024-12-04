

<form
    method="POST"
    action="<?= url('Anounces/store') ?>"
>

    <div class="form-group">
        <label for="anounce">Notifica tu anuncio</label>
        <textarea name="anounce" id="anounce" cols="20" rows="10" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label for="vigencia">Vigencia</label>
        <input type="date" name="vigencia" id="vigencia" class="form-control" required>
    </div>
    
    <button type="submit" class="btn btn-outline-primary mt-2 mb-2">Enviar</button>

</form>