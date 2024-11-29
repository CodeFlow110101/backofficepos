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



function drag() {
  return {
      startY: 0,
      translateY: 0,
      isDragging: false,

      startDragging(event) {
          this.isDragging = true;
          this.startY = event.touches ? event.touches[0].clientY : event.clientY;
      },

      drag(event) {
          if (!this.isDragging) return;
          const currentY = event.touches ? event.touches[0].clientY : event.clientY;
          const distance = currentY - this.startY;

          if (distance > 0 && distance < 150) {
              this.translateY = distance; // Adjust sensitivity here
          }
      },

      stopDragging() {
          this.isDragging = false;

          // Reset or snap back based on the position
          if (this.translateY > 100) {
              this.translateY = 100; // You can add more logic here for actions like notifications
          } else {
              this.translateY = 0;
          }
      },
  }
}