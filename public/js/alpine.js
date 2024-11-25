function deliveryStockQuantityValidator() {
  return {
    quantity: null,
    stockId: null,
    avlStock: null,
    stockPrice: null,
    totalStock: null,
    get mask() {
      return "9".repeat(
        this.avlStock.toString().length == 1
          ? 2
          : this.avlStock.toString().length
      );
    },
    validate() {
      number = this.quantity;

      if (parseInt(this.quantity) > this.avlStock) {
        number = Math.floor(this.quantity / 10);
      } else if (this.quantity == "" || this.quantity == "00") {
        number = 0;
      }
      this.quantity = parseInt(number, 10).toString();
    }
  };
}
