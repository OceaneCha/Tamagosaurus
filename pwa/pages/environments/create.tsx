import { NextComponentType, NextPageContext } from "next";
import Head from "next/head";

import { Form } from "../../components/environment/Form";

const Page: NextComponentType<NextPageContext> = () => (
  <div>
    <div>
      <Head>
        <title>Create Environment</title>
      </Head>
    </div>
    <Form />
  </div>
);

export default Page;
