#/bin/bash

cat ./src/jquery/jquery.js \
    ./src/jquery/plugins/jquery.cache.js \
    ./src/jquery/plugins/jquery.cookie.js \
    ./src/jquery/plugins/jquery.query.js \
    ./src/jquery/plugins/jquery.include.js > ./tmp/joy.min.js

java -jar bin/yuicompressor.jar ./tmp/joy.min.js -o ./build/joy.min.js

java -jar bin/js.jar ./bin/packer.js ./build/joy.min.js ./build/joy.pack.js

rm -rf ./tmp/*.js
