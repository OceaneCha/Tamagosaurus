import { NextComponentType, NextPageContext } from "next";
import Head from "next/head";

import { Form } from "../../components/species/Form";

const Page: NextComponentType<NextPageContext> = () => (
  <div>
    <div>
      <Head>
        <title>Create Species</title>
      </Head>
    </div>
    <Form />
  </div>
);

export default Page;
