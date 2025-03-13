# 1. plugin/.plugin
- COPY and rename to plugin.php
- Change the Plugin Name
- Change the description

# 2. In the PLUGIN directory
- Search and replace ALL occurences of \NAS\ with the new plugin acronym

# 3. plugin/app/Services/_Validation.php
- COPY and rename to Validation.php and uncomment
- Edit as required

# 4. plugin/app/_Config.php
- COPY and rename to Config.php
- Set pluginTitle (should match plugin name)
- Set validationClass to the class created at point #3