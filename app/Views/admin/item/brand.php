<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3>Marques d'objet</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <form action="/admin/item/createbrand" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5>Ajouter une marque</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">Nom de la marque</label>
                    <input type="text" class="form-control" name="name">
                    <label class="form-label">Marque parente</label>
                    <select class="form-select" name="id_brand_parent">
                        <option value="" selected>Aucun</option>
                        <?php foreach ($all_brands as $brand) { ?>
                            <option value="<?= $brand['id']; ?>">
                                <?= $brand['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
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
                <h5>Liste des marques</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover" id="tableBrands">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Parent</th>
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
<div class="modal" tabindex="-1" id="modalBrand">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier ma marque</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?= base_url('/admin/item/updatebrand'); ?>" id="formModal">
                <div class="modal-body">
                    <input type="hidden" name="id" value="">
                    <label class="form-label">Nom de la marque</label>
                    <input type="text" name="name" class="form-control">
                    <label class="form-label">Marque parente</label>
                    <select class="form-select" name="id_brand_parent">
                        <option value="" selected>Aucun</option>
                        <?php foreach ($all_brands as $brand) { ?>
                            <option value="<?= $brand['id']; ?>">
                                <?= $brand['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
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
        const modalBrand = new bootstrap.Modal('#modalBrand');
        var dataTable = $('#tableBrands').DataTable({
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
                "data" : { 'model' : 'ItemBrandModel'}

            },
            "columns": [
                {"data": "id"},
                {
                    data : 'id_brand_parent',
                    render : function(data) {
                        if (data == null) {
                            return `<span class='id-brand-parent'></span>`;
                        } else {
                            return `<span class='id-brand-parent'>${data}</span>`;
                        }
                    }
                },
                {
                    data : 'name',
                    render : function(data) {
                        return `<span class='name-brand'>${data}</span>`;
                    }
                },
                {
                    data : 'slug',
                    render : function(data) {
                        return `<span class='slug-brand'>${data}</span>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-brand-update" id="${data}" href="<?= base_url('/admin/item/updatebrand/');?>${data}"><i class="fa-solid fa-pencil text-success"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-brand" id="${data}" href="<?= base_url('/admin/item/deletebrand/');?>${data}"><i class="fa-solid fa-trash text-danger"></i></a>`;
                    }
                }
            ]
        });
        $("body").on('click', '.swal2-brand', function(event) {
            event.preventDefault();
            let title = $(this).attr("swal2-title");
            let text = $(this).attr("swal2-text");
            let link = $(this).attr('href');
            let id = $(this).attr("id");
            if (id == 1) {
                Swal.fire("On ne peut pas supprimer \"Aucune Marque\" !");
            } else {
                $.ajax({
                    type: "GET",
                    url: "<?= base_url('/admin/item/totalitembybrand'); ?>",
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        let json = JSON.parse(data);
                        let title = "Supprimer un genre"
                        let text = `Cette marque est attribuée à <b class="text-danger">${json.total}</b> objets.
                        Êtes-vous sûr de vouloir continuer ?`;
                        warningswal2(title,text,link);
                    }
                })
            }
        });
        $("body").on('click', '.swal2-brand-update', function(event) {
            event.preventDefault();
            modalBrand.show();
            let id_brand = $(this).attr('id');
            let name = $(this).closest('tr').find(".name-brand").html();
            let id_brand_parent = $(this).closest('tr').find(".id-brand-parent").html();
            $('.modal input[name="id"]').val(id_brand);
            $('.modal input[name="name"]').val(name);
            $('.modal select[name="id_brand_parent"]').val(id_brand_parent);
        });
        $("#formModal").on('submit', function(event) {
            event.preventDefault();
            let id_brand = $('.modal input[name="id"]').val();
            let name_brand = $('.modal input[name="name"]').val();
            let id_brand_parent = $('.modal select[name="id_brand_parent"]').val();
            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data : {
                    id : id_brand,
                    name : name_brand,
                    id_brand_parent : id_brand_parent,
                },
                success: function (data) {
                    //je transforme mon contenu pour l'utiliser en javascript
                    var json = JSON.parse(data);
                    //déclaration de ma ligne pour l'utiliser plusieurs fois
                    const ligne = $('#'+id_brand).closest('tr');
                    //modification des differents champs
                    ligne.find('.slug-brand').html(json.slug);
                    ligne.find('.name-brand').html(json.name);
                    ligne.find('.id-brand-parent').html(json.id_brand_parent);
                    //fermeture de la modal
                    modalBrand.hide();
                }
            });
        });
    })
</script>