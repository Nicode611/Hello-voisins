AWS.config.update({
    accessKeyId: 'AKIAZH3QK4A0E05WHD3S',
    secretAccessKey: '1400QdOwDj4HOXgLYCLQMHgfUsLgWdrPVWOcZXcF',
  region: 'EUROPE'
});

const s3 = new AWS.S3();

s3.listBuckets((err, data) => {
  if (err) {
    console.error('Erreur de connexion à AWS S3 :', err);
  } else {
    console.log('Connexion à AWS S3 réussie. Compartiments S3 disponibles :', data.Buckets);
  }
});