<!-- subir archivos + boton  -->
      <!-- <?php if (isFounder($_SESSION['username'], $course['title'])): ?>
        <form class="flex flex-col gap-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
          enctype="multipart/form-data">
          <div class="file-upload-panel" onclick="document.getElementById('fileInput').click();">
            Subir nuevos videos
            <input type="file" name="video" id="fileInput" class="file-upload-input">
          </div>
          <input id="btn-add" type="submit" name="submit" value="Añadir">
          <?php echo '<input type="hidden" name="courseID" value ="' . $course['title'] . '">'; ?>
        <?php endif; ?>
        <hr>
        <section class="course-content">
          <?php foreach ($videos as $video)
            echo (showVideosHTML($video)); ?>
        </section> -->