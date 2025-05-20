// FILE: JS/script.js

// Inicializa o carrinho a partir do localStorage ou como array vazio
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Função para exibir alertas
function mostrarAlerta(mensagem, tipo, formId = null) {
    const errorMessage = document.getElementById('error-message');
    if (errorMessage) {
        errorMessage.textContent = mensagem;
        errorMessage.style.color = tipo === 'danger' || tipo === 'warning' ? 'red' : 'green';
        errorMessage.style.display = 'block';
    } else {
        const alerta = obterAlerta();
        alerta.className = `alert alert-${tipo}`;
        alerta.textContent = mensagem;
        alerta.classList.remove('d-none');
        alerta.style.color = tipo === 'danger' || tipo === 'warning' ? 'red' : 'green';
        alerta.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
        alerta.style.border = tipo === 'danger' || tipo === 'warning' ? '1px solid red' : '1px solid green';
        alerta.style.padding = '10px';
        alerta.style.marginTop = '10px';
        alerta.style.borderRadius = '5px';
        alerta.style.textAlign = 'center';

        if (formId) {
            const form = document.getElementById(formId);
            if (form) {
                form.appendChild(alerta);
            }
        } else {
            document.body.appendChild(alerta);
        }

        setTimeout(() => {
            alerta.classList.add('d-none');
        }, 3000);
    }
}

function obterAlerta() {
    let alerta = document.getElementById('alerta');
    if (!alerta) {
        alerta = document.createElement('div');
        alerta.id = 'alerta';
        alerta.className = `alert d-none`;
        alerta.setAttribute('role', 'alert');
        document.body.appendChild(alerta);
    }
    return alerta;
}

// Função para alternar a visibilidade dos links de login/cadastro e perfil/logout
function verificarAutenticacao() {
    if (!isLoggedIn()) {
        // Handle the case when the user is not logged in
    }
    const profileLink = document.getElementById('profileLink');
    const logoutLink = document.getElementById('logoutLink');
    const loginLink = document.getElementById('loginLink');
    const cadastroLink = document.getElementById('cadastroLink');

    if (isLoggedIn) { // Use a variável global isLoggedIn
        if (profileLink) {
            profileLink.style.display = 'block';
        }
        if (logoutLink) {
            logoutLink.style.display = 'block';
        }
        if (cadastroLink) {
            cadastroLink.style.display = 'none';
        }
        if (loginLink) {
            loginLink.style.display = 'none';
        }
    } else {
        if (profileLink) {
            profileLink.style.display = 'none';
        }
        if (logoutLink) {
            logoutLink.style.display = 'none';
        }
        if (cadastroLink) {
            cadastroLink.style.display = 'block';
        }
        if (loginLink) {
            loginLink.style.display = 'block';
        }
    }
}

// Função para alternar o menu
function menutoggle() {
    const menuItems = document.getElementById('MenuItems');
    const menuIcon = document.querySelector('.menu-icon');
    if (menuItems.style.maxHeight === '0px' || menuItems.style.maxHeight === '') {
        menuItems.style.maxHeight = '200px'; // Ajuste conforme necessário
        menuItems.classList.add('active');
        menuIcon.classList.add('change');
    } else {
        menuItems.style.maxHeight = '0px';
        menuItems.classList.remove('active');
        menuIcon.classList.remove('change');
    }
}

// Inicializa o estado do menu
document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.getElementById('MenuItems');
    if (menuItems) {
        menuItems.style.maxHeight = '0px';
    }
    const menuIcon = document.querySelector('.menu-icon');
    if (menuIcon) {
        menuIcon.addEventListener('click', menutoggle);
    }
    verificarAutenticacao(); // Chama a função correta para atualizar os botões do menu
});

// Função para adicionar produto ao carrinho
function adicionarAoCarrinho(id) {
    // Verificar se estamos na página index.php ou em uma subpágina
    const pathPrefix = window.location.pathname.includes('/view/') ? '../' : '';
    fetch(`${pathPrefix}../backend/api/getProductsById.php?id=${id}`) // Corrigir o caminho
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    const produto = data.produto;
                    const existe = cart.find(item => item.id === produto.id);
                    if (existe) {
                        mostrarAlerta('Produto já está no carrinho.', 'warning');
                    } else {
                        // Corrigir o caminho da imagem
                        produto.imagem = `${pathPrefix}${produto.imagem}`;
                        cart.push(produto);
                        mostrarAlerta('Produto adicionado ao carrinho!', 'success');
                        atualizarCarrinho();
                    }
                } else {
                    mostrarAlerta(data.message || 'Erro ao adicionar produto ao carrinho.', 'danger');
                }
            } catch (error) {
                console.error('Erro:', error);
                mostrarAlerta('Erro ao adicionar produto ao carrinho.', 'danger');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            mostrarAlerta('Erro ao adicionar produto ao carrinho.', 'danger');
        });
}

// Função para atualizar o carrinho na Sidebar
function atualizarCarrinho() {
    const cartItems = document.getElementById('cartItems');
    if (cartItems) {
        cartItems.innerHTML = '';
        cart.forEach(produto => {
            const item = document.createElement('div');
            item.className = 'cart-item';
            item.innerHTML = `
                <img src="${produto.imagem}" alt="${produto.nome}" width="50">
                <span>${produto.nome}</span>
                <span>R$${produto.preco}</span>
                <button class="btn-remove" onclick="removerDoCarrinho(${produto.id})">&times;</button>
            `;
            cartItems.appendChild(item);
        });
    }

    // Atualizar o contador de itens no carrinho
    const cartCount = document.getElementById('cart-count');
    if (cartCount) {
        cartCount.textContent = cart.length;
    }

    // Salva o carrinho no localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Função para remover produto do carrinho
function removerDoCarrinho(id) {
    cart = cart.filter(produto => produto.id !== id);
    atualizarCarrinho();
    mostrarAlerta('Produto removido do carrinho.', 'success');
}

// Função para alternar o carrinho Sidebar
function toggleCart() {
    const cartSidebar = document.getElementById("cartSidebar");
    const overlay = document.getElementById("overlay");
    if (cartSidebar && overlay) {
        if (cartSidebar.style.right === "-300px" || cartSidebar.style.right === "") {
            cartSidebar.style.right = "0px";
            overlay.style.display = "block";
        } else {
            cartSidebar.style.right = "-300px";
            overlay.style.display = "none";
        }
    }
}

// Função para finalizar compra
function checkout() {
    if (cart.length === 0) {
        mostrarAlerta('Seu carrinho está vazio.', 'warning');
        return;
    }

    // Registrar a compra no backend
    fetch('../../backend/api/registerPurchase.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ cart })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarAlerta('Compra finalizada!', 'success');
            cart = [];
            atualizarCarrinho();
            toggleCart();
        } else {
            mostrarAlerta(data.message || 'Erro ao finalizar compra.', 'danger');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        mostrarAlerta('Erro ao finalizar compra.', 'danger');
    });
}

// LOGIN
document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            fetch('../../backend/api/loginAPI.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarAlerta('Login realizado com sucesso!', 'success');
                        setTimeout(() => {
                            window.location.href = '../view/dashboard.php'; // Redireciona após 2 segundos
                        }, 2000);
                    } else {
                        mostrarAlerta(data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    mostrarAlerta('Erro ao tentar fazer login.', 'danger');
                });
        });
    }
});

// CADASTRO
document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(registerForm);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            fetch('../../backend/api/register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarAlerta('Usuário cadastrado com sucesso!', 'success', 'registerForm');
                        setTimeout(() => {
                            window.location.href = '../view/login.php'; // Redireciona após 2 segundos
                        }, 2000);
                    } else {
                        mostrarAlerta(data.message, 'danger', 'registerForm');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    mostrarAlerta('Erro ao tentar registrar.', 'danger', 'registerForm');
                });
        });
    }
});

// Função para atualizar a lista de produtos (Admin)
function atualizarListaProdutos() {
    fetch('../../backend/api/getProducts.php')
        .then(response => response.json())
        .then(data => {
            console.log('Resposta do servidor:', data); // Log para depuração
            if(data.success){
                const listaProdutos = document.getElementById('listaProdutos').querySelector('tbody');
                listaProdutos.innerHTML = '';
                data.produtos.forEach(produto => {
                    const preco = parseFloat(produto.preco); // Converte para número
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${produto.id}</td>
                        <td>${produto.nome}</td>
                        <td>R$${preco.toFixed(2)}</td>
                        <td><img src="${produto.imagem}" alt="${produto.nome}" width="50"></td>
                        <td>
                            <button onclick="editarProduto(${produto.id}, '${produto.nome}', ${preco}, '${produto.imagem}')">Editar</button>
                            <button onclick="removerProduto(${produto.id})">Remover</button>
                        </td>
                    `;
                    listaProdutos.appendChild(tr);
                });
            } else {
                mostrarAlerta(data.message || 'Erro ao carregar produtos.', 'danger');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            mostrarAlerta('Erro ao carregar produtos.', 'danger');
        });
}

// Função para remover produto (Admin)
function removerProduto(id) {
    if (confirm('Tem certeza que deseja deletar este produto?')) {
        fetch(`../backend/api/deleteProduct.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarAlerta('Produto removido com sucesso!', 'success');
                atualizarListaProdutos();
            } else {
                mostrarAlerta('Erro ao remover produto.', 'danger');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            mostrarAlerta('Erro ao remover produto.', 'danger');
        });
    }
}

// Função para deletar produtos selecionados (Admin)
function deletarProdutosSelecionados() {
    const checkboxes = document.querySelectorAll('.product-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.getAttribute('data-product-id'));

    if (ids.length === 0) {
        mostrarAlerta('Nenhum produto selecionado para deletar.', 'warning');
        return;
    }

    if (confirm(`Tem certeza que deseja deletar ${ids.length} produto(s)?`)) {
        fetch(`../backend/api/deleteMultipleProducts.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    atualizarListaProdutos();
                    mostrarAlerta(`${ids.length} produto(s) removido(s) com sucesso!`, 'success');
                    document.getElementById('deleteSelected').disabled = true;
                } else {
                    mostrarAlerta(data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                mostrarAlerta('Erro ao deletar os produtos selecionados.', 'danger');
            });
    }
}

// Função para habilitar/desabilitar o botão de deletar selecionados (Admin)
function toggleDeleteButton() {
    const checkboxes = document.querySelectorAll('.product-checkbox:checked');
    const deleteSelectedButton = document.getElementById('deleteSelected');
    if (deleteSelectedButton) {
        deleteSelectedButton.disabled = checkboxes.length === 0;
    }

    // Atualizar o estado do checkbox "Selecionar Todos"
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        const totalCheckboxes = document.querySelectorAll('.product-checkbox').length;
        const checkedCheckboxes = checkboxes.length;
        selectAllCheckbox.checked = totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes;
    }
}

// Função para abrir o modal de edição (Admin)
function abrirModalEdicao(produto) {
    document.getElementById('updateId').value = produto.id;
    document.getElementById('updateNome').value = produto.nome;
    document.getElementById('updatePreco').value = produto.preco;
    document.getElementById('updateImagem').value = produto.imagem;

    // Abrir o modal
    $('#updateModal').modal('show');
}

// FUNCTION TO HANDLE CREATE PRODUCT (ADMIN)
function criarProduto(dados) {
    fetch('../backend/api/createProduct.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados) // 'descricao' is not included
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarAlerta(data.message, 'success');
                formProduto.reset();
                atualizarListaProdutos();
            } else {
                mostrarAlerta(data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            mostrarAlerta('Erro ao adicionar produto.', 'danger');
        });
}

// Manipulador de submissão do formulário de Atualização de Produto (Admin)
const updateForm = document.getElementById('updateForm');
if (updateForm) {
    updateForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const id = document.getElementById('updateId').value;
        const nome = document.getElementById('updateNome').value.trim();
        const preco = parseFloat(document.getElementById('updatePreco').value);
        const imagem = document.getElementById('updateImagem').value.trim();

        if (!nome || isNaN(preco) || !imagem) {
            mostrarAlerta('Por favor, preencha todos os campos corretamente.', 'danger');
            return;
        }

        const dados = { id, nome, preco, imagem };

        fetch('../backend/api/updateProduct.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dados) // 'descricao' is not included
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta(data.message, 'success');
                    updateForm.reset();
                    atualizarListaProdutos();
                    $('#updateModal').modal('hide');
                } else {
                    mostrarAlerta(data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                mostrarAlerta('Erro ao atualizar o produto.', 'danger');
            });
    });
}

// Manipulador de submissão do formulário de Edição de Usuário
const editUserForm = document.getElementById('editUserForm');
if (editUserForm) {
    editUserForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const id = document.getElementById('editUserId').value;
        const name = document.getElementById('editUserName').value.trim();
        const email = document.getElementById('editUserEmail').value.trim();
        const role = document.getElementById('editUserRole').value;

        if (!name || !email || !role) {
            mostrarAlerta('Por favor, preencha todos os campos.', 'danger');
            return;
        }

        const dados = { id, nome: name, email, role };

        fetch('../../backend/api/editUser.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dados)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta(data.message, 'success');
                    editUserForm.reset();
                    document.getElementById('editUserModal').style.display = 'none';
                    location.reload();
                } else {
                    mostrarAlerta(data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                mostrarAlerta('Erro ao editar usuário.', 'danger');
            });
    });
}

// Event Listener para checkbox "Selecionar Todos" (Admin)
const selectAllCheckbox = document.getElementById('selectAll');
if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
// Função para editar usuário
        toggleDeleteButton();
    });
}

// Event Listener para checkboxes individuais (Admin)
document.body.addEventListener('change', function (event) {
    if (event.target.classList.contains('product-checkbox')) {
        toggleDeleteButton();
    }
});

// Event Listener para Botão Deletar Selecionados (Admin)
const deleteSelectedButton = document.getElementById('deleteSelected');
if (deleteSelectedButton) {
    deleteSelectedButton.addEventListener('click', deletarProdutosSelecionados);
}

// Event Listener para Botões de Adicionar ao Carrinho (Index)
const addToCartButtons = document.querySelectorAll('.add-to-cart');
addToCartButtons.forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.getAttribute('data-product-id');
        adicionarAoCarrinho(productId);
    });
});

// Initialize the cart display on page load
document.addEventListener('DOMContentLoaded', function() {
    const cartItems = document.getElementById('cartItems');
    if (cartItems) {
        atualizarCarrinho();
    }

    // Hide error message on login/register forms
    var errorMessage = document.getElementById('error-message');
    if (errorMessage) {
        errorMessage.style.display = 'none';
    }
    
    verificarAutenticacao(); // Chama a função correta para atualizar os botões do menu
});

function editarUsuario(id) {
    // Obter os dados atuais do usuário
    fetch(`../../backend/api/getUserById.php?id=${id}`) // Corrected path
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                // Preencher um formulário de edição (implemente o modal/form conforme necessário)
                // Exemplo:
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editUserName').value = user.nome; // Corrected column name to 'nome'
                document.getElementById('editUserEmail').value = user.email;
                document.getElementById('editUserRole').value = user.role;
                // Mostrar o modal de edição
                document.getElementById('editUserModal').style.display = 'block';
            } else {
                mostrarAlerta(data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            mostrarAlerta('Erro ao buscar dados do usuário.', 'danger');
        });
}

// Função para excluir usuário
function excluirUsuario(id) {
    console.log(`Tentando excluir usuário com ID: ${id}`);
    if (confirm('Tem certeza que deseja excluir este usuário?')) {
        fetch(`../../backend/api/delete_user.php`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}`
        })
        .then(response => {
            console.log('Resposta do servidor:', response);
            return response.text(); // Alterado para text() para depuração
        })
        .then(text => {
            console.log('Texto recebido do servidor:', text);
            try {
                const data = JSON.parse(text);
                console.log('Dados recebidos do servidor:', data);
                if (data.success) {
                    alert('Usuário excluído com sucesso.');
                    location.reload();
                } else {
                    alert('Erro ao excluir usuário.');
                }
            } catch (error) {
                console.error('Erro ao analisar JSON:', error);
                console.error('Resposta do servidor:', text);
                alert('Erro ao excluir usuário.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao excluir usuário.');
        });
    }
}

function isLoggedIn() {
    // Implement the logic to check if the user is logged in
    return true; // Example return value
}

document.addEventListener('DOMContentLoaded', function() {
    verificarAutenticacao();
});
