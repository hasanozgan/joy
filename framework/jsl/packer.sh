#/bin/bash

# concat
cat ./src/jquery/jquery.js \
    ./src/jquery/plugins/jquery.cache.js \
    ./src/jquery/plugins/jquery.cookie.js \
    ./src/jquery/plugins/jquery.hotkeys.js \
    ./src/jquery/plugins/jquery.query.js \
    ./src/jquery/plugins/jquery.include.js > ./build/joy.js

# compressor
java -jar bin/yuicompressor.jar ./build/joy.js -o ./build/joy.min.js

# packer
java -jar bin/js.jar ./bin/packer.js ./build/joy.min.js ./build/joy.pack.js

