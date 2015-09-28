$('.image').change(function(e){
        var files = e.target.files;
        $('.img_prew').attr({
            src:URL.createObjectURL(files[0])
        }).css({
            width:'150px',
            height:'150px',
            marginTop:'10px'
        });
    }
);

