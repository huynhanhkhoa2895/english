<script>
products = ['a','d','e','f'];
productPrices = [2,4,6,8];
productSold = ['f','f'];
soldPrice = [8,8];
function priceCheck(products, productPrices, productSold, soldPrice) {
    // Write your code here
    let pro = {};
    let incorect = 0;
    products.forEach((e,k)=>{
        pro[e] = {};
        productPrices.forEach((e2,k2)=>{
            if(k == k2){
                pro[e] = e2;
            }
        })
    })
    productSold.forEach((e,k)=>{
        let price = pro[e]
        soldPrice.forEach((e2,k2)=>{
            if(price != e2 && k == k2){
                incorect++;
            }
        })
    })
    console.log(incorect)
    return incorect;
}
priceCheck(products, productPrices, productSold, soldPrice);
</script>