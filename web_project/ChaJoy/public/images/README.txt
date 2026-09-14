Place beverage images here (e.g. cappuccino.jpg, milk-tea.jpg, default.jpg).
The UI currently shows an emoji icon (🥤) as a placeholder wherever an image
would normally appear, so the site works immediately even with no images
uploaded. Add real photos here with matching filenames (see database/chajoy_db.sql
for the expected image names) and update the <div class="beverage-img"> blocks
in the views to use <img src="public/images/<?php echo $b['image']; ?>"> instead
of the emoji if you want real photos.
