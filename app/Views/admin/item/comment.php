<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3>Commentaires</h3>
            </div>
        </div>
    </div>
</div>

    <div class="col">
        <div class="card">
            <div class="card-header">
                <h5>Liste des commentaires</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover" id="tableComment">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom de l'object</th>
                        <th>Contenue</th>
                        <th>Réponse</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>Modifier</th>
                        <th>Suprimer</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tbody>
                    <?php foreach ($comments as $comment) : ?>
                        <tr>
                            <td><?= $comment['id'] ?></td>
                            <td><a href="/admin/item/<?= $comment['entity_id'] ?>"><?= $comment['name'] ?></td>
                            <td><?= $comment['content'] ?></td>
                            <td><?= $comment['reponse'] ?></td>
                            <td><a href="/admin/user/<?= $comment['id_user'] ?>"><?= $comment['username'] ?></a></td>
                            <td><?= $comment['date'] ?></td>
                            <td>
                                <a href="/admin/comment/<?=$comment['id'];?>" class="btn btn-outline-primary">
                                    <i class="fa-solid fa-feather"></i>
                                </a>
                            </td>

                            <td> <a href="/admin/comment/delete/<?=$comment['id']; ?>" class="btn btn-outline-danger">
                                    <i class="fa-regular fa-trash-can"></i>
                                </a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                    </tr>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
