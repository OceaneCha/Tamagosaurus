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

import { Show } from "../../../components/environment/Show";
import { PagedCollection } from "../../../types/collection";
import { Environment } from "../../../types/Environment";
import { fetch, FetchResponse, getItemPaths } from "../../../utils/dataAccess";
import { useMercure } from "../../../utils/mercure";

const getEnvironment = async (id: string | string[] | undefined) =>
  id
    ? await fetch<Environment>(`/environments/${id}`)
    : Promise.resolve(undefined);

const Page: NextComponentType<NextPageContext> = () => {
  const router = useRouter();
  const { id } = router.query;

  const {
    data: { data: environment, hubURL, text } = { hubURL: null, text: "" },
  } = useQuery<FetchResponse<Environment> | undefined>(
    ["environment", id],
    () => getEnvironment(id)
  );
  const environmentData = useMercure(environment, hubURL);

  if (!environmentData) {
    return <DefaultErrorPage statusCode={404} />;
  }

  return (
    <div>
      <div>
        <Head>
          <title>{`Show Environment ${environmentData["@id"]}`}</title>
        </Head>
      </div>
      <Show environment={environmentData} text={text} />
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
    "/environments/[id]"
  );

  return {
    paths,
    fallback: true,
  };
};

export default Page;
