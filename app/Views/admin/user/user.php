<div class="row">
    <div class="col">
        <form action="<?= isset($utilisateur) ? base_url("/admin/user/update") : base_url("/admin/user/create") ?>" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <?= isset($utilisateur) ? "Editer " . $utilisateur['username'] : "Créer un utilisateur" ?>
                    </h4>
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-profil" role="presentation">
                        <button class="nav-link active" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil-pane" type="button" role="tab" aria-controls="profil" aria-selected="true">Profil</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment-pane" type="button" role="tab" aria-controls="comment" aria-selected="false">Commentaires</button>
                    </li>

                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane fade show active" id="profil-pane" role="tabpanel" aria-labelledby="profil-tab" tabindex="0">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="username" class="form-label">Pseudo</label>
                                <input type="text" class="form-control" id="username" placeholder="username" value="<?= isset($utilisateur) ? $utilisateur['username'] : ""; ?>" name="username">
                            </div>
                            <div class="mb-3">
                                <label for="mail" class="form-label">E-mail</label>
                                <input type="text" class="form-control" id="mail" placeholder="mail" value="<?= isset($utilisateur) ? $utilisateur['email'] : "" ?>" name="email" <?= isset($utilisateur) ? "readonly" : "" ?> >
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" placeholder="password" value="" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="id_permission" class="form-label">Rôle</label>
                                <select class="form-select" id="id_permission" name="id_permission">
                                    <option disabled <?= !isset($utilisateur) ? "selected":""; ?> >Selectionner un role</option>
                                    <?php foreach($permissions as $p): ?>
                                        <option value="<?= $p['id']; ?>" <?= ( isset($utilisateur) && $p['id'] == $utilisateur['id_permission']) ? "selected" : "" ?> >
                                            <?= $p['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Avatar</label>
                                <input class="form-control" type="file" name="profile_image" id="image">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="comment-pane" role="tabpanel" aria-labelledby="comment-tab" tabindex="0">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col p-3">
                                        <?php foreach($comments as $comment) : ?>
                                            <div class="card mb-3 comment" data-id="<?= $comment['id']; ?>">
                                                <div class="card-header d-flex justify-content-between">

                                                    <div>
                                                        <small class="text-body-secondary">Le
                                                            <?php
                                                            $date = new DateTime($comment['date']);
                                                            echo $date->format('d/m/Y H:i:s'); ?></small>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <?= $comment['content']; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <?php if (isset($utilisateur)): ?>
                        <input type="hidden" name="id" value="<?= $utilisateur['id']; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($utilisateur) ? "Sauvegarder" : "Enregistrer" ?>
                    </button>
                </div>
            </div>


        </form>
    </div>
</div>