function showMessage(message, callback) {
    // Define o texto do corpo do modal
    $('#messageModal .modal-body').text(message);

    $('#messageModal .confirm-button').off('click').on('click', function () {
      callback();
  });
    
    // Exibe o modal
    var myModal = new bootstrap.Modal(document.getElementById('messageModal'));
    myModal.show();
  }
  