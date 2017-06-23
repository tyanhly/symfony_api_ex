# symfony_api_ex


## Setup mysql database for first time 

```
php bin/console doctrine:database:create

php bin/console doctrine:schema:update --force

```

## Elasticsearch Using

### Edit java option 
```
#elasticsearch-5.4.2/config/jvm.options
-Xms128m
-Xmx512m
```
### Run elastic search
```
bin/elasticsearch
```
### Check node health
```
curl -XGET 'localhost:9200/_cat/health?v&pretty'
```
### Check indices
```
curl -XGET 'localhost:9200/_cat/indices?v&pretty'
```
### Create index
```
curl -XPUT 'localhost:9200/customer?pretty&pretty'
curl -XGET 'localhost:9200/_cat/indices?v&pretty'
```
### Put data 
```
curl -XPUT 'localhost:9200/customer/external/1?pretty&pretty' -H 'Content-Type: application/json' -d'
{
  "name": "John Doe"
}
'
```
### Query data
```
curl -XGET 'localhost:9200/customer/external/1?pretty&pretty'

```

