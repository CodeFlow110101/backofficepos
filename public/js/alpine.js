function deliveryStockQuantityValidator() {
  return {
    quantity: null,
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

function saleTotalPriceCalculator() {
  return {
    stocks: null,
    get calculate() {
      total = 0;
      this.stocks.forEach(value => {
        total += value.quantity * value.stock.inventory.price;
      });
      return total;
    }
  };
}

function handleFile() {
  return {
    handleFileSelect(event) {
      const file = event.target.files[0];

      if (file) {
        this.$wire.fileName = file.name;
        this.$wire.fileSize = Math.floor(file.size / (1024 * 1024));
      } else {
        this.$wire.fileName = "";
        this.$wire.fileSize = null;
      }
    },
    uploadFile() {
      Livewire.dispatch("loader", { value: true });

      var formData = new FormData();
      var file = this.$refs.file.files[0];
      formData.append("file", file);

      $.ajax({
        url: "/upload-file",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          Livewire.dispatch("handle-file", {
            name: response["name"],
            path: response["path"]
          });
        }
      });
    }
  };
}
