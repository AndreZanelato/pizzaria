let cart = [];
const cartBtn = document.querySelector('.cart-btn');
const cartSidebar = document.querySelector('.cart-sidebar');
const cartItemsElement = document.querySelector('.cart-items');
const totalPriceElement = document.getElementById('total-price');
const cartCountElement = document.getElementById('cart-count');
const paymentMethodSelect = document.getElementById('payment-method');

// Exibe os produtos da lista
function displayProducts() {
    const productList = document.querySelector('.product-list');
    products.forEach(product => {
        const productElement = document.createElement('div');
        productElement.classList.add('product');
        productElement.innerHTML = `
            <img src="${product.image}" alt="${product.name}">
            <h3>${product.name}</h3>
            <p><strong>Ingredientes:</strong> ${product.description}</p>
            <p>Preço: R$ ${product.price.toFixed(2)}</p>
            <button class="add-to-cart" data-id="${product.id}">Adicionar ao carrinho</button>
        `;
        productList.appendChild(productElement);
    });

    // Adicionar eventos de clique aos botões
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', addToCart);
    });
}

// Adicionar produto ao carrinho
function addToCart(event) {
    const productId = parseInt(event.target.getAttribute('data-id'));
    const product = products.find(p => p.id === productId);

    const existingProduct = cart.find(item => item.id === productId);
    if (existingProduct) {
        existingProduct.quantity++;
    } else {
        cart.push({ id: productId, name: product.name, price: product.price, quantity: 1 });
    }

    updateCart();
}

// Atualizar carrinho e exibir total
function updateCart() {
    cartItemsElement.innerHTML = ''; // Limpa o conteúdo antigo
    let total = 0;
    let totalItems = 0;

    cart.forEach(item => {
        cartItemsElement.innerHTML += `<p>${item.name} - Qtd: ${item.quantity} - R$ ${(item.price * item.quantity).toFixed(2)}</p>`;
        total += item.price * item.quantity;
        totalItems += item.quantity;
    });

    totalPriceElement.innerText = `R$ ${total.toFixed(2)}`;
    cartCountElement.innerText = totalItems; // Atualiza a contagem no botão do carrinho

    // Mostrar o botão do carrinho se houver itens
    if (totalItems > 0) {
        cartBtn.style.display = 'block';
    } else {
        cartBtn.style.display = 'none';
    }
}

// Abrir/fechar o menu lateral do carrinho
function toggleCartMenu() {
    cartSidebar.classList.toggle('open');
}

// Função para gerar as opções de apartamento
function populateApartmentOptions() {
    const apartmentSelect = document.getElementById('apartamento');
    for (let i = 101; i <= 1008; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.text = `Apt ${i}`;
        apartmentSelect.appendChild(option);
    }
}

/// Redirecionar para WhatsApp
function proceedToWhatsApp() {
    const paymentMethod = paymentMethodSelect.value;
    const blocoApartamento = document.getElementById('bloco-apartamento').value;

    let message = "Olá, gostaria de pedir:\n";
    cart.forEach(item => {
        message += `- ${item.quantity} pizza(s) de ${item.name}\n`;
    });
    message += ` $Forma de pagamento: ${paymentMethod}\n`;
    message += ` #Informações de entrega: ${blocoApartamento}\n`;

    const encodedMessage = encodeURIComponent(message);
    const whatsappURL = `https://wa.me/5531999999999?text=${encodedMessage}`;
    window.location.href = whatsappURL;
}

// Inicializar página de produtos
document.addEventListener('DOMContentLoaded', () => {
    displayProducts();
    populateApartmentOptions(); // Preencher os apartamentos
});
