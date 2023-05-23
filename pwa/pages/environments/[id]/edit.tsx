import {
  GetStaticPaths,
  GetStaticProps,
  NextComponentType,
  NextPageContext,
} from "next";
import DefaultErrorPage from "next/error";
import Head from "next/head";
import { useRouter } from "next/router";
import { dehydrate, QueryClient, useQuery } from "react-query";

import { Form } from "../../../components/environment/Form";
import { PagedCollection } from "../../../types/collection";
import { Environment } from "../../../types/Environment";
import { fetch, FetchResponse, getItemPaths } from "../../../utils/dataAccess";

const getEnvironment = async (id: string | string[] | undefined) =>
  id
    ? await fetch<Environment>(`/environments/${id}`)
    : Promise.resolve(undefined);

const Page: NextComponentType<NextPageContext> = () => {
  const router = useRouter();
  const { id } = router.query;

  const { data: { data: environment } = {} } = useQuery<
    FetchResponse<Environment> | undefined
  >(["environment", id], () => getEnvironment(id));

  if (!environment) {
    return <DefaultErrorPage statusCode={404} />;
  }

  return (
    <div>
      <div>
        <Head>
          <title>
            {environment && `Edit Environment ${environment["@id"]}`}
          </title>
        </Head>
      </div>
      <Form environment={environment} />
    </div>
  );
};

export const getStaticProps: GetStaticProps = async ({
  params: { id } = {},
}) => {
  if (!id) throw new Error("id not in query param");
  const queryClient = new QueryClient();
  await queryClient.prefetchQuery(["environment", id], () =>
    getEnvironment(id)
  );

  return {
    props: {
      dehydratedState: dehydrate(queryClient),
    },
    revalidate: 1,
  };
};

export const getStaticPaths: GetStaticPaths = async () => {
  const response = await fetch<PagedCollection<Environment>>("/environments");
  const paths = await getItemPaths(
    response,
    "environments",
    "/environments/[id]/edit"
  );

  return {
    paths,
    fallback: true,
  };
};

export default Page;
