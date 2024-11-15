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
                    <label class="form-label">Nom de du genre</label>
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
<div class="modal" tabindex="-1" id="modalGenre">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier mon genre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?= base_url('/admin/item/updategenre'); ?>" id="formModal">
                <div class="modal-body">
                    <input type="hidden" name="id" value="">
                    <label class="form-label">Nom du genre</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <input type="submit" class="btn btn-primary" value="Valider">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const modalGenre = new bootstrap.Modal('#modalGenre');
        var baseUrl = "<?= base_url(); ?>";
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
                {
                    data : 'name',
                    render : function(data) {
                        return `<span class='name-genre'>${data}</span>`;
                    }
                },
                {
                    data : 'slug',
                    render : function(data) {
                        return `<span class='slug-genre'>${data}</span>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-genre-update" id="${data}"
                        href="${baseUrl}/admin/item/updategenre/${data}"><i class="fa-solid fa-pencil
                        text-success"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-genre" id="${data}" href="${baseUrl}/admin/item/deletegenre/${data}"><i class="fa-solid fa-trash text-danger"></i></a>`;
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
                Swal.fire("On ne peut pas supprimer \"Non classé\" !");
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
                        let text = `Cette licence est attribuée à <b class="text-danger">${json.total}</b> objets.
                        Êtes-vous sûr de vouloir continuer ?`;
                        warningswal2(title,text,link);
                    }
                })
            }
        });
        $("body").on('click', '.swal2-genre-update', function(event) {
            event.preventDefault();
            modalGenre.show();
            let id_genre = $(this).attr('id');
            let name = $(this).closest('tr').find(".name-genre").html();
            $('.modal input[name="id"]').val(id_genre);
            $('.modal input[name="name"]').val(name);
        });
        $("#formModal").on('submit', function(event) {
            event.preventDefault();
            let id_genre = $('.modal input[name="id"]').val();
            let name_genre = $('.modal input[name="name"]').val();
            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data : {
                    id : id_genre,
                    name : name_genre,
                },
                success: function (data) {
                    console.log(data);
                    //je transforme mon contenu pour l'utiliser en javascript
                    var json = JSON.parse(data);
                    //déclaration de ma ligne pour l'utiliser plusieurs fois
                    const ligne = $('#'+id_genre).closest('tr');
                    //modification des differents champs
                    ligne.find('.slug-genre').html(json.slug);
                    ligne.find('.name-genre').html(json.name);
                    //fermeture de la modal
                    modalGenre.hide();
                }
            });
        });
    })
</script>