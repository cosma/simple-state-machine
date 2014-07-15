##
#  Download and install Graphviz in graphviz/
##
mkdir -p graphviz/man/

wget -O graphviz.tar.gz --quiet http://www.graphviz.org/pub/graphviz/stable/SOURCES/graphviz-working.tar.gz

tar -zxf graphviz.tar.gz

cd graphviz-2.38.0

./configure --exec_prefix=/home/ubuntu/src/bitbucket.org/cosma/simplestatemachine/graphviz \
--prefix=/home/ubuntu/src/bitbucket.org/cosma/simplestatemachine/graphviz \
--mandir=/home/ubuntu/src/bitbucket.org/cosma/simplestatemachine/graphviz/man 

make 
make install 

cd ..

ls -all graphviz/bin/



echo 'make alias'
alias dot='graphviz/bin/dot'

graphviz/bin/dot -V


##
# Install php project dependencies through composer
##
composer install --prefer-source


##
# Run tests
##

phpunit --coverage-text --coverage-html=tests/coverage tests
