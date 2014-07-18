##
#  Download and install Graphviz in graphviz/
##
mkdir -p graphviz/man/

wget -O graphviz.tar.gz --quiet http://www.graphviz.org/pub/graphviz/stable/SOURCES/graphviz-working.tar.gz

tar -zxf graphviz.tar.gz

cd graphviz-2.38.0

./configure --silent \
--exec_prefix=/home/ubuntu/src/bitbucket.org/cosma/simple-state-machine/graphviz \
--prefix=/home/ubuntu/src/bitbucket.org/cosma/simple-state-machine/graphviz \
--mandir=/home/ubuntu/src/bitbucket.org/cosma/simple-state-machine/graphviz/man  

make --silent --ignore-errors && make --silent --ignore-errors install > /dev/null

cd ..

echo 'export path'
export PATH=$PATH:/home/ubuntu/src/bitbucket.org/cosma/simple-state-machine/graphviz/bin


echo 'which dot'
which dot

echo 'dot  version:'
dot -V


##
# Install php project dependencies through composer
##
composer install --prefer-source


##
# Run tests
##

phpunit --coverage-text --coverage-html=tests/coverage tests
