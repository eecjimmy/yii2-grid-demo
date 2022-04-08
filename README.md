## Yii GridView Demo

- 部署步骤

```shell
# 运行
docker-compose up --build -d

# 更新`composer.json` 如果由于网络问题失败后可重试
docker-compose exec -u33 -T php-fpm composer update -vvv --no-cache --optimize-autoloader

# 合并数据
yes | ./yii-docker migrate

# 打开: http://127.0.0.1:7200 可查看
```

- 演示: [http://8.210.81.61:7200](http://8.210.81.61:7200)