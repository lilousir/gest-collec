<form method="POST" action="<?= base_url('/user/sendmessage'); ?>">
    <div class="card">
        <div class="card-header">
            Envoyer un message à <?= $username ?>.
        </div>
        <div class="card-body">
            <input type="hidden" name="username_receiver" value="<?= $username; ?>">
            <div class="mb-3">
                <label for="subject" class="form-label">Sujet du message</label>
                <input type="text" class="form-control" id="subject" name="subject">
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Contenu du message</label>
                <textarea class="form-control" id="content" rows="3" name="content"></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Envoyer le message</button>
        </div>
    </div>
</form>