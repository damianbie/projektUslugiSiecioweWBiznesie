# $ result=$(mysql -h bazadanych -u root -p example -e "use app")
# $ if [[ $result -eq 0 ]]
# then
#     echo "The database exists"
# else
#     echo "The database doesn’t exist"
# fi