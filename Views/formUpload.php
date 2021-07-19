<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNG TO JPG</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <?php echo form_open_multipart(base_url() . '/Image/upload', [
        'id' => 'uploadF'
    ]); ?>
    <div class="mt-5"></div>
    <div class="container">
        <div class="d-flex justify-content-center mb-3 col-lg-12">
            <div class="form-group">
                <label for="exampleFormControlFile1">Example file input</label>
                <input type="file" name="file" class="form-control-file file" require accept="image/png">
            </div>
            <div>
                <button type="submit" class=" btn btn-primary btn-sm" id="btnSubmit">Upload</button>
            </div>
            <?php echo form_close(); ?>
            <a href="#" class="btn btn-info download d-none btn-sm">
                Download
            </a>
        </div>
        <div class="progress d-flex justify-content-center mb-3 col-lg-12 d-none">
            <div class="progress-bar progress-bar-striped bg-danger  progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</body>
<script>
    onFileChange();
    onSubmit();
    
    function onFileChange() {
        $(".file").change(function() {
            hideProgress();
            hideDownload();
        });
    }

    function hideProgress() {
        $(".progress").addClass('d-none');
    }

    function showProgress() {
        $(".progress").removeClass('d-none');
    }

    function hideDownload() {
        $(".download").addClass('d-none');
    }

    function showDownload(image) {
        $(".download").removeClass('d-none');
        $(".download").attr('href', "<?php echo base_url(); ?>" + "/Image/download/" + image);
    }

    function onSubmit() {
        $("#btnSubmit").click(function(e) {

            showProgress();

            e.preventDefault();
            const form = $('#uploadF')[0];
            const formData = new FormData(form);
            console.log(formData);

            $.ajax({
                type: "post",
                url: $("#uploadF").attr('action'),
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    hideProgress();
                    if (response.success == true) {
                        showDownload(response.message);
                    }
                }
            });
        })
    }
</script>

</html>
