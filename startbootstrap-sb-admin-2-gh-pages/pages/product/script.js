function togglePromotionField() {
    var promotionSelect = document.getElementById('prd_promotion');
    var promotionPriceInput = document.getElementById('prd_promotion_price');
    
    // Enable or disable the promotion price field based on the selected option
    if (promotionSelect.value === '1') {
        promotionPriceInput.readOnly = false;
    } else {
        promotionPriceInput.readOnly = true;
        promotionPriceInput.value = ''; // Clear the value
    }
}