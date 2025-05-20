<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" type="text/css" href="../css/cadastro.css" />
    <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon">
    <title>Cadastro com formulário</title>
</head>
<body>
    <section class="container">
        <div class="logo">
            <a href="../index.php"><img src="../img/logo.png" alt="logo" width="70"></a>
        </div>
        <header>Formulário de registro</header>
        <form id="registerForm" class="form" method="post">
            <div class="input-box">
                <label for="Nome">Nome completo</label>
                <input type="text" id="Nome" name="nome" placeholder="Nome completo" required />
            </div>
            <div class="input-box">
                <label for="Email">Endereço de e-mail</label>
                <input type="email" id="Email" name="email" placeholder="Endereço de e-mail" required />
            </div>
            <div class="input-box">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite a sua senha" required />
            </div>
            <div class="input-box">
                <label for="confirm_senha">Confirmação de Senha</label>
                <input type="password" id="confirm_senha" name="confirm_senha" placeholder="Digite a sua senha" required />
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="telefone">Número de telefone</label>
                    <input type="number" id="telefone" name="telefone" placeholder="Número de telefone" required />
                </div>
                <div class="input-box">
                    <label for="data_nascimento">Data de nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" required />
                </div>
            </div>
            <div class="gender-box">
                <h3>Gênero</h3>
                <div class="gender-option">
                    <div class="gender">
                        <input type="radio" id="check-male" name="genero" value="masculino" checked />
                        <label for="check-male">Masculino</label>
                    </div>
                    <div class="gender">
                        <input type="radio" id="check-female" name="genero" value="feminino" />
                        <label for="check-female">Feminino</label>
                    </div>
                    <div class="gender">
                        <input type="radio" id="check-other" name="genero" value="outro" />
                        <label for="check-other">Prefere não dizer</label>
                    </div>
                </div>
            </div>
            <div class="input-box address">
                <label>Endereço</label>
                <input type="text" id="endereco1" name="endereco1" placeholder="Endereço 1" required />
                <input type="text" id="endereco2" name="endereco2" placeholder="Endereço 2" required />
                <div class="input-box">
                    <label for="pais">País</label>
                    <select id="pais" name="pais">
                        <option hidden>País</option>
                        <option>Brasil</option>
                        <option>Inglaterra</option>
                        <option>USA</option>
                        <option>Mexico</option>
                    </select>
                </div>
                <div class="input-box">
                    <label for="cidade">Cidade</label>
                    <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required />
                </div>
                <div class="input-box">
                    <label for="regiao">Região</label>
                    <select id="regiao" name="regiao">
                        <option hidden>Região</option>
                        <option value="AC">AC</option>
                        <option value="AL">AL</option>
                        <option value="AP">AP</option>
                        <option value="AM">AM</option>
                        <option value="BA">BA</option>
                        <option value="CE">CE</option>
                        <option value="DF">DF</option>
                        <option value="ES">ES</option>
                        <option value="GO">GO</option>
                        <option value="MA">MA</option>
                        <option value="MS">MS</option>
                        <option value="MT">MT</option>
                        <option value="MG">MG</option>
                        <option value="PA">PA</option>
                        <option value="PB">PB</option>
                        <option value="PR">PR</option>
                        <option value="PE">PE</option>
                        <option value="PI">PI</option>
                        <option value="RJ">RJ</option>
                        <option value="RN">RN</option>
                        <option value="RS">RS</option>
                        <option value="RO">RO</option>
                        <option value="RR">RR</option>
                        <option value="SC">SC</option>
                        <option value="SP">SP</option>
                        <option value="SE">SE</option>
                        <option value="TO">TO</option>
                    </select>
                </div>
                <div class="input-box">
                    <label for="CEP">CEP</label>
                    <input type="text" id="CEP" name="cep" placeholder="Digite o CEP" pattern="\d{5}-\d{3}" required />
                </div>
            </div>
            <input type="submit" name="Enviar" id="submit">
        </form>
    </section>
    <script src="../JS/script.js"></script>
</body>
</html>