<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div id="post-content">
        {{ $corresponding_post->content }}
    </div>
</body>

</html>
<script>
    let ConvertStringToHTML = function(str) {
        let parser = new DOMParser();
        let doc = parser.parseFromString(str, 'text/html');
        return doc.body;
    };
    let post_content = document.getElementById('post-content');
    let post_content_converted = ConvertStringToHTML(post_content.innerText)
    post_content.innerHTML = post_content_converted.innerHTML
</script>
