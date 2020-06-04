<html>
    <head>
        <title>PagSeguro</title>
    </head>
    <body>
        <h1>Example Checkout PagSeguro</h1>
        
        <script
            src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
            crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script type="text/javascript" 
            src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js">
        </script>
        <script>
            function session(){
                $.ajax({
                    url : "<?= base_url('/pagseguro/session'); ?>",
                    type : 'post',
                    dataType: 'json',
                    beforeSend : function(){
                        Swal.fire('Loading Session!');
                    }
                })
                .done(function(data){
                    Swal.fire("Success! Generate Session.");
                    PagSeguroDirectPayment.setSessionId(data.id);
                })
                .fail(function(jqXHR, textStatus, msg){
                    Swal.fire('Error!');
                })
            }
            session();
        </script>
    </body>
</html>