# trieTree
>   一段学习经历

    公司项目遇到这样一种情况：需要一系列的参数指向某一结果，例如表示{'name' => 'a'}的值的查找。在项目中的实现方式是通过对json字符串计算md5作为checksum，并在数据库中分别存储该值。查找时将要求按照特定规则排序之后，计算md5并进行查找。

    然而由于md5计算出来的结果并不短，数据库会进行较长的长字符串匹配，即便是增加了索引，一定程度上性能仍然不是很好。

    正好前不久查看nginx proxy cache的时候看到了一些关于缓存的查找的内容，有一部分是nginx缓存会以长字符串作为名称存储其缓存的内容，为了提高查找效率，nginx会截取字符串前一段内容作为目录。例如有一个文件名称为abcdefghijklm.txt的文件，那么最后会生成/ab/cd/abcdefghijklm.txt。这种方式也与公司使用的cloudflare CDN缓存的查找策略一致。

    于是我想到了使用类似的方案，最初是希望能够做出可以直接为项目服务的内容，但是在查找资料的过程中，我才了解到这一数据结构的原型就是Tire Tree，或者称为Prefix Tree（前缀树,或称字典树）。另外Mysql也同样提供了前缀索引使用。公司项目需要优化的部分只需要应用前缀索引即可。最后便打消了原有计划，只准备实现一个简短的小工具。

    需要指出的是Php的Array本身效率已经很高，其中很多的内部实现都使用了该数据类型，Hash也是工程性能很强的算法。在有更好的方案时，完全没有必要再自己动手写轮子。

> My learning experience
    I met such problem in my working project: We need find a result from a series of parameters ,for example, find a specific data from object {'name' => b}. In our project ,we achieved it by count the md5 of the json encodeed data string as checksum code, and stored it in database. When we need to find the data, just sort the object by specific rule, then select from the database.

    //todo 
