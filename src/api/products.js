import apollo11ServiceClient from './';

export const getProducts = async () => {
  const response = await apollo11ServiceClient({
    url: 'products',
    method: 'get',
  });

  return response;
};
