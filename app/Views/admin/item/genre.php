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
        <form action="/admin/item/creategenre" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5>Ajouter un genre</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">Nom du genre</label>
                    <input type="text" class="form-control" name="name">

                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Valider</button>
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
        var dataTable = $('#tableGenres').DataTable({
            "responsive": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "language": {
                url: '<?= base_url("/js/datatable/datatable-2.1.4-fr-FR.json") ?>',
            },
            "ajax" : {
                "url" : "<?= base_url('/admin/item/searchdatatable'); ?>",
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
                        return `<a class="swal2-genre" id="${data}" swal2-title="Etes-vous sur de vouloir supp" swal2-text="" href="<?= base_url('/admin/item/deletegenre/'); ?>${data}"><i class="fa-solid
                        fa-trash text-danger"></i></a>`;
                    }
                }
            ]

        });
        $("body").on('click', '.swal2-genre', function(event) {
            event.preventDefault();
            let title = $(this).attr("swal2-title");
            let text = $(this).attr("swal2-text");
            let link = $(this).attr("href");
            let id = $(this).attr("id");
            if (id == 1) {
                Swal.fire("sur de vouloir faire sa ");
            } else {
                $.ajax({
                    type: "GET",
                    url: "<?= base_url('/admin/item/totalitembygenre'); ?>",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        let json = JSON.parse(data);
                        console.log(json.total);
                        let title = "Supprimer un genre"
                        let text = `ce genre est attribué à <b class="text-warning">${json.total}</b> objets. etes-vous sur de vouloir continuer ?`;
                        warningswal2(title,text,link);
                    }
                })
            }
        });
    })
</script>
