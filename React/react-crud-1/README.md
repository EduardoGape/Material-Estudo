
## Instructions

Fork, then download or clone the repo.
```bash
git clone https://github.com/<your-user-name>/mern-crud.git
```


*Make sure MongoDB service is running.*

The *config* folder contains a file named *db.js*. Before running locally, change the value of db as seen in the code below.
```js
module.exports = {
  db: 'mongodb://localhost/mern-crud'
};
```

For the **back-end**, install the dependencies once via the terminal.
```bash
npm install
```

Run the *main server*. It listens on port 3000.
```bash
CORS=1 node server
```
View it on the browser.

<br>

If you want to configure the **front-end**, go to *react-src* folder via the terminal.

```bash
cd react-src
```

Install the dependencies required by React once.
```bash
npm install
```

Run the *development server* for React. It listens on port 4200.
```bash
REACT_APP_API_URL=http://localhost:3000 npm start
```

To make a production build, simply run on *react-src* folder via the terminal.
```bash
npm run build
```

It re-creates a folder named *public* on the root directory. This is where the production-ready front-end of the web application resides.

