<?php if (isset($comment['id'])) : ?>
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <form method="POST" action="<?= base_url('/admin/comment/update'); ?>">
                    <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                    <div class="card-header">
                        Modifier le commentaire
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" name="content" rows="3"><?= $comment['content'] ?></textarea>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Infos
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
<?php
endif; ?>