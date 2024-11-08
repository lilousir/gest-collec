<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3>Genres d'objet</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <form action="<?= base_url('/admin/item/creategenre'); ?>" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5>Ajouter un genre</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">Nom du genre</label>
                    <input type="text" class="form-control" name="name">
                    <label class="form-label">Genre parente</label>
                    <select class="form-select" name="id_genre_parent">
                        <option value="" selected>Aucun</option>
                        <?php foreach ($all_genres as $genre) { ?>
                            <option value="<?= $genre['id']; ?>">
                                <?= $genre['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="card-footer text-end">
                    <button  type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Liste des genres</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover" id="tableGenres">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Slug</th>
                        <th>Modif.</th>
                        <th>Supp.</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var baseUrl = <?= base_url(); ?>;
        var dataTable = $('#tableGenres').DataTable({
            "responsive": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "language": {
                url: baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            },
            "ajax" : {
                "url" : baseUrl + "admin/item/searchdatatable",
                "type" : "POST",
                "data" : { 'model' : 'ItemGenreModel'}

            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "slug"},
                {"data": "slug"},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-genre" id="${data}" href="${baseUrl}admin/item/deletegenre/${data}"><i class="fa-solid fa-trash text-danger"></i></a>`;
                    }
                }
            ]
        });
        $("body").on('click', '.swal2-genre', function(event) {
            event.preventDefault();
            let title = $(this).attr("swal2-title");
            let text = $(this).attr("swal2-text");
            let link = $(this).attr('href');
            let id = $(this).attr("id");
            if (id == 1) {
                Swal.fire("On ne peut pas supprimer \"Aucun Genre\" !");
            } else {
                $.ajax({
                    type: "GET",
                    url: baseUrl + "admin/item/totalitembygenre",
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        let json = JSON.parse(data);
                        let title = "Supprimer un genre"
                        let text = `Ce genre est attribué à <b class="text-danger">${json.total}</b> objets. Êtes-vous sûr de vouloir continuer ?`;
                        warningswal2(title,text,link);
                    }
                })
            }
        });
    })
</script>