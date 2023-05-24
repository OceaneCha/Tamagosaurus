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

import { Show } from "../../../components/species/Show";
import { PagedCollection } from "../../../types/collection";
import { Species } from "../../../types/Species";
import { fetch, FetchResponse, getItemPaths } from "../../../utils/dataAccess";
import { useMercure } from "../../../utils/mercure";

const getSpecies = async (id: string | string[] | undefined) =>
  id ? await fetch<Species>(`/species/${id}`) : Promise.resolve(undefined);

const Page: NextComponentType<NextPageContext> = () => {
  const router = useRouter();
  const { id } = router.query;

  const { data: { data: species, hubURL, text } = { hubURL: null, text: "" } } =
    useQuery<FetchResponse<Species> | undefined>(["species", id], () =>
      getSpecies(id)
    );
  const speciesData = useMercure(species, hubURL);

  if (!speciesData) {
    return <DefaultErrorPage statusCode={404} />;
  }

  return (
    <div>
      <div>
        <Head>
          <title>{`Show Species ${speciesData["@id"]}`}</title>
        </Head>
      </div>
      <Show species={speciesData} text={text} />
    </div>
  );
};

export const getStaticProps: GetStaticProps = async ({
  params: { id } = {},
}) => {
  if (!id) throw new Error("id not in query param");
  const queryClient = new QueryClient();
  await queryClient.prefetchQuery(["species", id], () => getSpecies(id));

  return {
    props: {
      dehydratedState: dehydrate(queryClient),
    },
    revalidate: 1,
  };
};

export const getStaticPaths: GetStaticPaths = async () => {
  const response = await fetch<PagedCollection<Species>>("/species");
  const paths = await getItemPaths(response, "species", "/speciess/[id]");

  return {
    paths,
    fallback: true,
  };
};

export default Page;
