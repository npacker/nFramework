<!DOCTYPE html>
<html>
<head>
<title>500: Internal Server ERror</title>
<meta charset="UTF-8">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css">
<style type="text/css">
html, body {
  padding: 0;
  border: none;
  margin: 0;
}

body {
  background-color: #eee;
  color: #333;
  font-family: 'Open Sans', sans-serif;
  font-size: 100%;
  line-height: 1.5;
}

.page {
  padding: 3em 25%;
}

blockquote, div, form, header, h1, h2, h3, h4, h5, h6, hr, iframe, object, ol, p, table, ul {
  margin: 0;
  margin-bottom: 1.5em;
}

*:last-child {
  margin-bottom: 0;
}

h1, h2, h3, h4, h5, h6 {
  font-weight: normal;
}

h1 {
  font-size: 350%;
}

h2 {
  font-size: 250%;
}

header h1:before {
  content: " ";
  width: 50px;
  height: 1.5em;
  float: left;
  margin-right: 0.25em;
  background: transparent url("nFramework/application/resources/images/logo.png") left center no-repeat;
}

.content {
  background-color: #d0d0d0;
  padding: 3em;
}

.message .content h2:before {
  float: left;
  background-color: transparent;
  background-position: top left;
  background-repeat: no-repeat;
  margin-right: 0.5em
}

.error h2:before {
  content: " ";
  background-image: url("nFramework/application/resources/images/error.png");
  width: 86px;
  height: 86px;
}

.warning h2:before {
  content: " ";
  background-image: url("nFramework/application/resources/images/warning.png");
  width: 86px;
  height: 86px;
}

.message article {
  font-size: 125%;
}
</style>
</head>
<body class="message error">
<div class="page">
  <header>
    <h1>nFramework</h1>
  </header>
  <section class="content">
    <h2>500: Internal Server Error</h2>
    <article>
      <p>The server encountered an error. We apologize for the inconvenience.</p>
    </article>
  </section>
</div>
</body>
</html>