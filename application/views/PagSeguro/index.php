<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PagSeguro</title>
        <link rel="stylesheet" href="/checkout_transparente/assets/css/style.css" >
    </head>
    <body>
        <h1>Exemplo Checkout PagSeguro</h1>

        <section id="data-card">      
            <form action="">
                <label for="number-card">Insira o número do cartão:</label>
                <input type="text" name="number-card" id="number-card"><br>
                <img src="" alt="" id="img-card">
            </form>
        </section>

        <section id="card-aceptable">     
            <h2>Formas de Pagamento Aceitas</h2>
            <div class="credit-card"><div class="title">Cartão de Crédito</div></div>
            <div class="billet"><div class="title">Boleto</div></div>
            <div class="debit"><div class="title">Débito Online</div></div>
        </section>

    </body>     
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript" 
        src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js">
    </script>
    <script>
        // Inicia sessão 
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
                listMethodsPayments();
            })
            .fail(function(jqXHR, textStatus, msg){
                Swal.fire('Error!');
            })
        }

        // Lista os métodos de pagamentos
        function listMethodsPayments()
        {
            PagSeguroDirectPayment.getPaymentMethods({
                amount: 0.01,
                success: function(data) {
                    $.each(data.paymentMethods.CREDIT_CARD.options, function(i, obj){
                        $('.credit-card').append("<div><img src=https://stc.pagseguro.uol.com.br/"+obj.images.SMALL.path+">"+obj.name+"</div>");
                    });

                    $('.billet').append("<div><img src=https://stc.pagseguro.uol.com.br/"+data.paymentMethods.BOLETO.options.BOLETO.images.SMALL.path+">"+data.paymentMethods.BOLETO.name+"</div>");

                    $.each(data.paymentMethods.ONLINE_DEBIT.options, function(i, obj){
                        $('.debit').append("<div><img src=https://stc.pagseguro.uol.com.br/"+obj.images.SMALL.path+">"+obj.name+"</div>");
                    });
                },
                complete: function(data) {
                }
            });
        }
        session();

        //Receber os dados do formulário, usando o evento "keyup" para receber sempre que tiver alguma alteração no campo do formulário
        $('#number-card').on('keyup', function () {
            
            //Receber o número do cartão digitado pelo usuário
            var numberCard = $(this).val();
            
            //Contar quantos números o usuário digitou
            var qtdNumber = numberCard.length;
            
            //Validar o cartão quando o usuário digitar 6 digitos do cartão
            if (qtdNumber == 6) {
                
                //Instanciar a API do PagSeguro para validar o cartão
                PagSeguroDirectPayment.getBrand({
                    cardBin: numberCard,
                    success: function (response) {
                        $('#msg').empty();
                        
                        //Enviar para o index a imagem da bandeira
                        var imgBrand = response.brand.name;
                        $('#img-card').attr('src',"https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/" + imgBrand + ".png");
                    },
                    error: function (response) {                        
                        //Enviar para o index a mensagem de erro
                        $('.img-card').empty();
                        Swal.fire('Error! Cartão Inválido!');
                    }
                });
            }
        });


    </script>
</html>