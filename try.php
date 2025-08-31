<?php if (!empty($message)): ?>
<script>
  showModal("<?php echo $message; ?>");
</script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
.custom-modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.5);
}

.custom-modal-content {
  background-color: #fff;
  margin: 15% auto;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 400px;
  text-align: center;
}

.custom-modal .close {
  position: absolute;
  right: 15px;
  top: 10px;
  font-size: 20px;
  cursor: pointer;
}
</style>
</head>
<body>
   <!-- Modale personnalisée -->
<div id="customModal" class="custom-modal">
  <div class="custom-modal-content">
    <span class="close">&times;</span>
    <p id="modalMessage"></p>
  </div>
</div>



<script>
function showModal(message) {
  const modal = document.getElementById('customModal');
  const modalMessage = document.getElementById('modalMessage');
  modalMessage.textContent = message;
  modal.style.display = "block";

  modal.querySelector('.close').onclick = () => { modal.style.display = "none"; };
  window.onclick = (e) => { if(e.target == modal) modal.style.display = "none"; };
}
</script>
 
</body>
</html>