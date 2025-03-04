document.querySelector("form").addEventListener("submit", function(e) {
    let cardNumber = document.querySelector("input[name='card_number']").value;
    let expiryDate = document.querySelector("input[name='expiry_date']").value;
    let cvv = document.querySelector("input[name='cvv']").value;
    let errors = [];

    // Validate card number
    if (cardNumber.length !== 16) {
        errors.push("Card number must be 16 digits.");
    }

    // Validate expiry date
    if (!expiryDate.match(/^(0[1-9]|1[0-2])\/([0-9]{2})$/)) {
        errors.push("Expiry date must be in MM/YY format.");
    }

    // Validate CVV
    if (cvv.length !== 3) {
        errors.push("CVV must be 3 digits.");
    }

    if (errors.length > 0) {
        e.preventDefault(); // Prevent form submission
        alert(errors.join("\n"));
    }
});