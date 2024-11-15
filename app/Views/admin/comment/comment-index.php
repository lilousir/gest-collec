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
            <table class="table table-sm table-hover" id="tableGenre">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>username</th>
                    <th>Réponse</th>
                    <th>Contenu</th>
                    <th>Nom de l'objet</th>
                    <th>Date</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>

                </tr>
                </thead>
                <tbody>

                <?php foreach ($comments as $comment): ?>
                <tr>

                    <td><?= $comment['id']?></td>
                    <td><a href="/admin/user/<?= $comment['id_user']?>"><?= $comment['username'];?></a> </td>
                    <td><?= $comment['reponse']?></td>
                    <td><?= $comment['content']?></td>
                    <td><a href="/admin/item/<?= $comment['entity_id']?>"><?= $comment['name']?></td>
                    <td><?= $comment['date']?></td>

                    <td><a href="/admin/comment/<?=$comment['id']; ?>" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a></td>

                    <td><a href="/admin/comment/delete/<?= $comment['id']?>" class="btn btn-danger"><i class="fa-solid fa-trash-can"></form></i></td>

                    <?php endforeach; ?>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
        </div>
    </div>
</div>