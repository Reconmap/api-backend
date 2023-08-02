window.onload = function() {
  //<editor-fold desc="Changeable Configuration Block">

  // the following lines will be replaced by docker/configurator, when it runs in a docker-container
  window.ui = SwaggerUIBundle({
      urls: [
          {url: "openapi.yaml", name: "Static API definition"},
          {url: "/openapi.json", name: "Dynamic API definition"},
      ],
    dom_id: '#swagger-ui',
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    plugins: [
      SwaggerUIBundle.plugins.DownloadUrl
    ],
    layout: "StandaloneLayout",
        apisSorter : "alpha",
        operationsSorter: "alpha",
        tagsSorter: "alpha",
  });

  //</editor-fold>
};
