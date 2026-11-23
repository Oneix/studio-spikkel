const checkout = document.querySelector('form[data-checkout]');
const address = checkout?.querySelector('[data-shipping-address]');
const message = checkout?.querySelector('[data-gift-message]');

if (checkout && address && message) {
    const wrap = checkout.querySelector('input[name="gift_wrap"][type="checkbox"]');
    const messageInput = message.querySelector('textarea');
    const updateOptions = () => {
        const method = checkout.querySelector('input[name="delivery_method"]:checked');
        const shipping = method?.value === 'shipping';
        address.hidden = !shipping;
        address.disabled = !shipping;
        address.querySelectorAll('input, select').forEach(field => { field.required = shipping; });
        message.hidden = !wrap.checked;
        messageInput.disabled = !wrap.checked;
    };
    checkout.addEventListener('change', updateOptions);
    updateOptions();
}
