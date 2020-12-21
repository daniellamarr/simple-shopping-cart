import apollo11ServiceClient from './';

export const createOrder = async (data) => {
  const response = await apollo11ServiceClient({
    url: 'orders',
    method: 'post',
    data,
    headers: {
      "Referrer-Policy": "no-referrer"
    }
  });

  return response;
};
